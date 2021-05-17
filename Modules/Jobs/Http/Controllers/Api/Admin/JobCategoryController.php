<?php

namespace Modules\Jobs\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Advertisings\Repositories\AdvertisingCategoryRepository;
use Modules\Advertisings\Transformers\AdvertisingTransformer;
use Modules\Jobs\Http\Requests\JobCategoryCreateApiRequest;
use Modules\Jobs\Repositories\JobCategoryRepository;
use Modules\Jobs\Service\JobCategoryService;
use Modules\Jobs\Transformers\JobCategoryTransformer;


/**
 * Class AdvertisingCategoryController
 * @property AdvertisingCategoryRepository $repository
 * @package Modules\Advertisings\Http\Controllers\Api
 */
class JobCategoryController extends BaseApiController
{
    protected $jobCategoryService;

    /**
     * AdvertisingsController constructor.
     * @param JobCategoryRepository $repository
     */
    public function __construct(JobCategoryRepository $repository, JobCategoryService $jobCategoryService)
    {
        parent::__construct($repository);

        $this->jobCategoryService = $jobCategoryService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $advertisingCategories = $this->repository->scopeQuery(function (Builder $query) {
            return $query->where('parent_id', 0);
        })->orderBy('created_at', 'desc')->paginate(intval($request->get('per_page')));

        return $this->responseSuccess($this->transform($advertisingCategories, JobCategoryTransformer::class, $request));
    }

    /**
     * @param $identifier
     * @param Request $request
     * @return JsonResponse
     */
    public function show($identifier, Request $request)
    {
        $entity = $this->repository->find($identifier);
        return $this->responseSuccess($this->transform($entity, JobCategoryTransformer::class, $request));
    }

    /**
     * @param JobCategoryCreateApiRequest $request
     * @return JsonResponse
     */
    public function store(JobCategoryCreateApiRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->only(['name', 'type', 'parent_id']);

            $category = $this->jobCategoryService->createCategory($data);

            DB::commit();
            return $this->responseSuccess($this->transform($category, JobCategoryTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();

            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @param $identifier
     * @param JobCategoryCreateApiRequest $request
     * @return JsonResponse
     */
    public function update($identifier, JobCategoryCreateApiRequest $request)
    {
        $entity = $this->repository->find($identifier);
        $storeValues = $request->only([]);
        DB::beginTransaction();
        try {
            $entity = $this->repository->update($storeValues, $entity->id);
            DB::commit();
            return $this->responseSuccess($this->transform($entity, AdvertisingTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }
}
