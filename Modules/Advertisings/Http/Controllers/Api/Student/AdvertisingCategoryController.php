<?php

namespace Modules\Advertisings\Http\Controllers\Api\Student;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Advertisings\Entities\AdvertisingCategory;
use Modules\Advertisings\Entities\AdvertisingStatus;
use Modules\Advertisings\Http\Requests\AdvertisingCategoryCreateApiRequest;
use Modules\Advertisings\Http\Requests\AdvertisingCreateApiRequest;
use Modules\Advertisings\Http\Requests\AdvertisingUpdateApiRequest;
use Modules\Advertisings\Repositories\AdvertisingCategoryRepository;
use Modules\Advertisings\Service\AdvertisingCategoryService;
use Modules\Advertisings\Transformers\AdvertisingCategoryTransformer;
use Modules\Advertisings\Transformers\AdvertisingTransformer;


/**
 * Class AdvertisingCategoryController
 * @property AdvertisingCategoryRepository $repository
 * @package Modules\Advertisings\Http\Controllers\Api
 */
class AdvertisingCategoryController extends BaseApiController
{
    protected $advertisingCategoryService;
    /**
     * AdvertisingsController constructor.
     * @param AdvertisingCategoryRepository $repository
     */
    public function __construct(AdvertisingCategoryRepository $repository, AdvertisingCategoryService $advertisingCategoryService )
    {
        parent::__construct($repository);

        $this->advertisingCategoryService = $advertisingCategoryService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $advertisingCategories = $this->repository->scopeQuery(function (Builder $query) {
            return $query->where('parent_id', 0);
        })->orderBy('created_at','desc')->paginate(intval($request->get('per_page')));

        return $this->responseSuccess($this->transform($advertisingCategories, AdvertisingCategoryTransformer::class, $request));
    }

    /**
     * @param $identifier
     * @param Request $request
     * @return JsonResponse
     */
    public function show($identifier, Request $request)
    {
        $entity = $this->repository->find($identifier);
        return $this->responseSuccess($this->transform($entity, AdvertisingCategoryTransformer::class, $request));
    }

    /**
     * @param AdvertisingCategoryCreateApiRequest $request
     * @return JsonResponse
     */
    public function store(AdvertisingCategoryCreateApiRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->only(['name','type','parent_id']);

            $category =  $this->advertisingCategoryService->createCategory($data);

            DB::commit();
            return $this->responseSuccess($this->transform($category, AdvertisingCategoryTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @param $identifier
     * @param AdvertisingUpdateApiRequest $request
     * @return JsonResponse
     */
    public function update($identifier, AdvertisingUpdateApiRequest $request)
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
