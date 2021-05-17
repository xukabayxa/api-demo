<?php

namespace Modules\Jobs\Http\Controllers\Api\Student;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Advertisings\Transformers\AdvertisingTransformer;
use Modules\Comments\Entities\Comment;
use Modules\Customers\Entities\Student;
use Modules\Jobs\Entities\Job;
use Modules\Jobs\Entities\JobStatus;
use Modules\Jobs\Http\Requests\CommentJobRequest;
use Modules\Jobs\Http\Requests\DeleteCommentJobRequest;
use Modules\Jobs\Http\Requests\FeedBackCommentJobRequest;
use Modules\Jobs\Http\Requests\UpdateCommentJobRequest;
use Modules\Jobs\Repositories\JobRepository;
use Modules\Jobs\Service\JobService;
use Modules\Jobs\Transformers\JobTransformer;
use Modules\Users\Entities\User;


/**
 * Class JobCommentController
 * @package Modules\Jobs\Http\Controllers\Api\Student
 */
class JobCommentController extends BaseApiController
{

    protected $jobService;

    /**
     * JobCommentController constructor.
     * @param JobRepository $repository
     * @param JobService $jobService
     */
    public function __construct(JobRepository $repository, JobService $jobService)
    {
        parent::__construct($repository);

        $this->jobService = $jobService;
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
     * @param CommentJobRequest $request
     * @return JsonResponse
     */
    public function store($id, CommentJobRequest $request)
    {
        DB::beginTransaction();
        try {
            $student = auth('student')->user();

            /** @var Job $job */
            $job = $this->repository->find($id);

            if ($job->status_id == JobStatus::CLOSE) {
                throw new \Exception('this job is closed');
            }

            $job->comments()->create([
                'content' => $request->input('content'),
                'commentable_id' => $job->id,
                'commentable_type' => Job::class,
                'creatable_id' => $student->id,
                'creatable_type' => Student::class,
                'parent_id' => 0,
            ]);

            DB::commit();
            return $this->responseSuccess($this->transform($job, JobTransformer::class, $request));
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
     * @param UpdateCommentJobRequest $request
     * @return JsonResponse
     */
    public function update($id, $commentId, UpdateCommentJobRequest $request)
    {
        DB::beginTransaction();
        try {
            /** @var Job $job */
            $job = $this->repository->find($id);

            if ($job->status_id == JobStatus::CLOSE) {
                throw new \Exception('this job is closed');
            }

            /** @var Comment $comment */
            $comment = $job->comments()->find($commentId);

            $this->validateUpdateComment($comment);

            $comment->content = $request->input('content');

            $comment->save();

            DB::commit();
            return $this->responseSuccess($this->transform($job, JobTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @param $id
     * @param $commentId
     * @param DeleteCommentJobRequest $request
     * @throws \Exception
     */
    public function destroy($id, $commentId, DeleteCommentJobRequest $request)
    {
        try {
            /** @var Job $job */
            $job = $this->repository->find($id);

            /** @var Comment $comment */
            $comment = $job->comments()->find($commentId);

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
     * @param FeedBackCommentJobRequest $request
     * @return JsonResponse
     */
    public function feedbackComment($id, $commentId, FeedBackCommentJobRequest $request)
    {
        try {
            $data['commentable_type'] = Job::class;
            $data['commentable_id'] = $id;
            $data['creatable_id'] = auth('student')->id();
            $data['creatable_type'] = Student::class;
            $data['content'] = $request->input('content');

            $job = $this->repository->find($id);

            $job = $this->jobService->feedbackComment($job, $commentId, $data);

            return $this->responseSuccess($this->transform($job, JobTransformer::class, $request));
        } catch (\Exception $exception) {
            Log::error($exception);
            DB::rollBack();
            return $this->responseErrors(500, $exception->getMessage());
        }
    }
}
