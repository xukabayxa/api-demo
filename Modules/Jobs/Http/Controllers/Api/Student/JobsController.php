<?php

namespace Modules\Jobs\Http\Controllers\Api\Student;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Advertisings\Http\Requests\UpdateStatusAdvertisingRequest;
use Modules\Customers\Entities\Student;
use Modules\Jobs\Entities\Job;
use Modules\Jobs\Entities\JobStatus;
use Modules\Jobs\Http\Requests\DeleteJobRequest;
use Modules\Jobs\Http\Requests\JobCreateApiRequest;
use Modules\Jobs\Http\Requests\JobUpdateApiRequest;
use Modules\Jobs\Http\Requests\UpdateStatusJobRequest;
use Modules\Jobs\Repositories\JobRepository;
use Modules\Jobs\Service\JobService;
use Modules\Jobs\Transformers\JobTransformer;
use Modules\Motels\Http\Requests\DeleteMotelRequest;


/**
 * Class JobsController
 * @property JobRepository $repository
 * @package Modules\Jobs\Http\Controllers\Api
 */
class JobsController extends BaseApiController
{
    protected $jobService;
    /**
     * JobsController constructor.
     * @param JobRepository $repository
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
        return $this->responseSuccess($this->transform($data, JobTransformer::class, $request));
    }

    /**
     * @param $identifier
     * @param Request $request
     * @return JsonResponse
     */
    public function show($identifier, Request $request)
    {
        $entity = $this->repository->find($identifier);
        return $this->responseSuccess($this->transform($entity, JobTransformer::class, $request));
    }

    /**
     * @param JobCreateApiRequest $request
     * @return JsonResponse
     */
    public function store(JobCreateApiRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->only(['title', 'short_content', 'content', 'area_id', 'job_category_id', 'intent_id', 'address', 'salary', 'type']);
            $data['status_id'] = JobStatus::OPEN;

            $files = $request->file('files');

            $schoolIds = $request->input('school_ids');

            /** @var Student $student */
            $student = auth('student')->user();

            $advertising = $this->jobService->createJob($data, $student, $schoolIds, $files);

            DB::commit();

            return $this->responseSuccess($this->transform($advertising, JobTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @param $identifier
     * @param JobUpdateApiRequest $request
     * @return JsonResponse
     */
    public function update($identifier, JobUpdateApiRequest $request)
    {
        $data = $request->only(['title', 'short_content', 'content', 'area_id', 'job_category_id', 'intent_id', 'address', 'salary', 'type']);

        DB::beginTransaction();
        try {
            $job = $this->repository->find($identifier);

            $schoolIds = $request->input('school_ids');

            $file_ids = $request->input('file_ids');

            $files = $request->file('files');

            $job = $this->jobService->updateJob($job, $data, $schoolIds, $file_ids, $files);

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
     * @param DeleteJobRequest $request
     * @return JsonResponse
     */
    public function destroy($id, DeleteJobRequest $request)
    {
        DB::beginTransaction();
        try {
            /** @var Job $motel */
            $job = $this->repository->find($id);

            $job->delete();

            DB::commit();
            return $this->responseSuccess([],200,'delete job success.');
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @param $id
     * @param UpdateStatusJobRequest $request
     */
    public function updateStatus($id, UpdateStatusJobRequest $request)
    {
        /** @var Job $job */
        $job = $this->repository->find($id);

        $job->status_id = $request->input('status_id');

        $job->save();

        return $this->responseSuccess();
    }
}
