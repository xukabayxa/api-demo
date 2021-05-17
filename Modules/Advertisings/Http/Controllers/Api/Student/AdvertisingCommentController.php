<?php

namespace Modules\Advertisings\Http\Controllers\Api\Student;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Advertisings\Entities\Advertising;
use Modules\Advertisings\Entities\AdvertisingStatus;
use Modules\Advertisings\Http\Requests\CommentAdvertisingRequest;
use Modules\Advertisings\Http\Requests\DeleteCommentAdvertisingRequest;
use Modules\Advertisings\Http\Requests\FeedBackCommentAdvertisingRequest;
use Modules\Advertisings\Http\Requests\UpdateCommentAdvertisingRequest;
use Modules\Advertisings\Repositories\AdvertisingRepository;
use Modules\Advertisings\Service\AdvertisingService;
use Modules\Advertisings\Transformers\AdvertisingTransformer;
use Modules\Comments\Entities\Comment;
use Modules\Customers\Entities\Student;
use Modules\Motels\Entities\Motel;
use Modules\Users\Entities\User;


/**
 * Class AdvertisingCommentController
 * @package Modules\Motels\Http\Controllers\Api\Student
 */
class AdvertisingCommentController extends BaseApiController
{

    public $advertisingService;

    /**
     * AdvertisingCommentController constructor.
     * @param AdvertisingRepository $repository
     * @param AdvertisingService $advertisingService
     */
    public function __construct(AdvertisingRepository $repository, AdvertisingService $advertisingService)
    {
        parent::__construct($repository);

        $this->advertisingService = $advertisingService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $data = $this->repository->paginate(intval($request->get('per_page')));
        return $this->responseSuccess($this->transform($data, AdvertisingTransformer::class, $request));
    }


    /**
     * @param $identifier
     * @param Request $request
     * @return JsonResponse
     */
    public function show($identifier, Request $request)
    {
        $entity = $this->repository->find($identifier);
        return $this->responseSuccess($this->transform($entity, AdvertisingTransformer::class, $request));
    }

    /**
     * @param $id
     * @param CommentAdvertisingRequest $request
     * @return JsonResponse
     */
    public function store($id, CommentAdvertisingRequest $request)
    {
        DB::beginTransaction();
        try {
            $student = auth('student')->user();

            /** @var Advertising $advertising */
            $advertising = $this->repository->find($id);

            if ($advertising->status_id == AdvertisingStatus::CLOSE) {
                throw new \Exception('this advertising is closed');
            }

            $advertising->comments()->create([
                'content' => $request->input('content'),
                'commentable_id' => $advertising->id,
                'commentable_type' => Advertising::class,
                'creatable_id' => $student->id,
                'creatable_type' => Student::class,
                'parent_id' => 0,
            ]);

            DB::commit();
            return $this->responseSuccess($this->transform($advertising, AdvertisingTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @param Comment $comment
     * @return bool
     * @throws \Exception
     */
    protected function validateUpdateComment($comment)
    {
        $student = auth('student')->user();

        $userComment = $comment->creatable;

        if ($userComment) {
            if (get_class($userComment) === User::class) {
                throw new \Exception('Comment is not valid');
            } else {
                if ($userComment->id !== $student->id) {
                    throw new \Exception('Comment is not valid');
                }
            }
        } else {
            throw new \Exception('Comment is not valid');
        }

        return true;
    }

    /**
     * @param $id
     * @param $commentId
     * @param UpdateCommentAdvertisingRequest $request
     * @return JsonResponse
     */
    public function update($id, $commentId, UpdateCommentAdvertisingRequest $request)
    {
        DB::beginTransaction();
        try {
            /** @var Advertising $advertising */
            $advertising = $this->repository->find($id);

            if ($advertising->status_id == AdvertisingStatus::CLOSE) {
                throw new \Exception('this advertising is closed');
            }

            /** @var Comment $comment */
            $comment = $advertising->comments()->find($commentId);

            $this->validateUpdateComment($comment);

            $comment->content = $request->input('content');

            $comment->save();

            DB::commit();
            return $this->responseSuccess($this->transform($advertising, AdvertisingTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @param $id
     * @param $commentId
     * @param DeleteCommentAdvertisingRequest $request
     * @throws \Exception
     */
    public function destroy($id, $commentId, DeleteCommentAdvertisingRequest $request)
    {
        try {
            /** @var Advertising $advertising */
            $advertising = $this->repository->find($id);

            /** @var Comment $comment */
            $comment = $advertising->comments()->find($commentId);

            $this->validateUpdateComment($comment);

            $comment->delete();

            return $this->responseSuccess([], 200, 'delete comment success.');
        } catch (\Exception $exception) {
            return $this->responseErrors(500, $exception->getMessage());
        }

    }

    /**
     * @param $id
     * @param $commentId
     * @param FeedBackCommentAdvertisingRequest $request
     * @return JsonResponse
     */
    public function feedbackComment($id, $commentId, FeedBackCommentAdvertisingRequest $request)
    {
        try {
            $data['commentable_type'] = Advertising::class;
            $data['commentable_id'] = $id;
            $data['creatable_id'] = auth('student')->id();
            $data['creatable_type'] = Student::class;
            $data['content'] = $request->input('content');

            $advertising = $this->repository->find($id);

            $advertising = $this->advertisingService->feedbackComment($advertising, $commentId, $data);

            return $this->responseSuccess($this->transform($advertising, AdvertisingTransformer::class, $request));
        } catch (\Exception $exception) {
            Log::error($exception);
            DB::rollBack();
            return $this->responseErrors(500, $exception->getMessage());
        }
    }
}
