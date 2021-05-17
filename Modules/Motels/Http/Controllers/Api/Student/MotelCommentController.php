<?php

namespace Modules\Motels\Http\Controllers\Api\Student;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Comments\Entities\Comment;
use Modules\Comments\Transformers\CommentTransformer;
use Modules\Customers\Entities\Student;
use Modules\Motels\Entities\Motel;
use Modules\Motels\Entities\MotelStatus;
use Modules\Motels\Http\Requests\CommentMotelRequest;
use Modules\Motels\Http\Requests\DeleteCommentRequest;
use Modules\Motels\Http\Requests\FeedBackCommentRequest;
use Modules\Motels\Http\Requests\MotelCreateApiRequest;
use Modules\Motels\Http\Requests\MotelUpdateApiRequest;
use Modules\Motels\Http\Requests\UpdateCommentMotelRequest;
use Modules\Motels\Repositories\MotelRepository;
use Modules\Motels\Service\MotelService;
use Modules\Motels\Transformers\MotelTransformer;
use Modules\Users\Entities\User;


/**
 * Class MotelsController
 * @property MotelRepository $repository
 * @package Modules\Motels\Http\Controllers\Api
 */
class MotelCommentController extends BaseApiController
{
    /**
     * MotelsController constructor.
     * @param MotelRepository $repository
     */
    public $motelService;

    public function __construct(MotelRepository $repository, MotelService $motelService)
    {
        parent::__construct($repository);

        $this->motelService = $motelService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $data = $this->repository->paginate(intval($request->get('per_page')));
        return $this->responseSuccess($this->transform($data, MotelTransformer::class, $request));
    }


    /**
     * @param $identifier
     * @param Request $request
     * @return JsonResponse
     */
    public function show($identifier, Request $request)
    {
        $entity = $this->repository->find($identifier);
        return $this->responseSuccess($this->transform($entity, MotelTransformer::class, $request));
    }

    /**
     * @param $id
     * @param MotelCreateApiRequest $request
     * @return JsonResponse
     */
    public function store($id, CommentMotelRequest $request)
    {
        DB::beginTransaction();
        try {
            $student = auth('student')->user();

            /** @var Motel $motel */
            $motel = $this->repository->find($id);

            if ($motel->status_id == MotelStatus::CLOSE) {
                throw new \Exception('this motel is closed');
            }

            $motel->comments()->create([
                'content' => $request->input('content'),
                'commentable_id' => $motel->id,
                'commentable_type' => Motel::class,
                'creatable_id' => $student->id,
                'creatable_type' => Student::class,
                'parent_id' => 0,
            ]);

            DB::commit();
            return $this->responseSuccess($this->transform($motel, MotelTransformer::class, $request));
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
     * @param MotelUpdateApiRequest $request
     * @return JsonResponse
     */
    public function update($id, $commentId, UpdateCommentMotelRequest $request)
    {
        DB::beginTransaction();
        try {
            /** @var Motel $motel */
            $motel = $this->repository->find($id);

            if ($motel->status_id == MotelStatus::CLOSE) {
                throw new \Exception('this motel is closed');
            }

            /** @var Comment $comment */
            $comment = $motel->comments()->find($commentId);

            $this->validateUpdateComment($comment);

            $comment->content = $request->input('content');

            $comment->save();
            DB::commit();
            return $this->responseSuccess($this->transform($motel, MotelTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @param $id
     * @param $commentId
     * @param DeleteCommentRequest $request
     * @throws \Exception
     */
    public function destroy($id, $commentId, DeleteCommentRequest $request)
    {
        try {
            /** @var Motel $motel */
            $motel = $this->repository->find($id);

            /** @var Comment $comment */
            $comment = $motel->comments()->find($commentId);

            $this->validateUpdateComment($comment);

            $comment->delete();

            return $this->responseSuccess([],200,'delete comment success.');
        } catch (\Exception $exception) {
            return $this->responseErrors(500, $exception->getMessage());
        }

    }

    /**
     * @param $id
     * @param $commentId
     * @param Request $request
     * @return JsonResponse
     */
    public function feedbackComment($id, $commentId, FeedBackCommentRequest $request)
    {
        try {
            $data['commentable_type'] = Motel::class;
            $data['commentable_id'] = $id;
            $data['creatable_id'] = auth('student')->id();
            $data['creatable_type'] = Student::class;
            $data['content'] = $request->input('content');

            $motel = $this->repository->find($id);

            $motel = $this->motelService->feedbackComment($motel, $commentId, $data);

            return $this->responseSuccess($this->transform($motel, MotelTransformer::class, $request));
        } catch (\Exception $exception) {
            Log::error($exception);
            DB::rollBack();
            return $this->responseErrors(500, $exception->getMessage());
        }
    }
}
