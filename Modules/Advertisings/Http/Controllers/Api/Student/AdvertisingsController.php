<?php

namespace Modules\Advertisings\Http\Controllers\Api\Student;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Advertisings\Entities\Advertising;
use Modules\Advertisings\Entities\AdvertisingStatus;
use Modules\Advertisings\Http\Requests\AdvertisingCreateApiRequest;
use Modules\Advertisings\Http\Requests\AdvertisingUpdateApiRequest;
use Modules\Advertisings\Http\Requests\UpdateStatusAdvertisingRequest;
use Modules\Advertisings\Repositories\AdvertisingRepository;
use Modules\Advertisings\Repositories\Criteria\MyAdvertisingCriteria;
use Modules\Advertisings\Service\AdvertisingService;
use Modules\Advertisings\Transformers\AdvertisingTransformer;
use Modules\Customers\Entities\Student;


/**
 * Class AdvertisingsController
 * @property AdvertisingRepository $repository
 * @package Modules\Advertisings\Http\Controllers\Api
 */
class AdvertisingsController extends BaseApiController
{
    protected $advertisingService;

    /**
     * AdvertisingsController constructor.
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
        $data = $this->repository->with(['comments', 'comments.creatable', 'creatable'])
            ->pushCriteria(new MyAdvertisingCriteria())
            ->paginate(intval($request->get('per_page')));
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
     * @param AdvertisingCreateApiRequest $request
     * @return JsonResponse
     */
    public function store(AdvertisingCreateApiRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->only(['title', 'short_content', 'content', 'area_id', 'advertising_category_id', 'intent_id', 'address', 'price']);
            $data['status_id'] = AdvertisingStatus::OPEN;

            $files = $request->file('files');

            $schoolIds = $request->input('school_ids');

            /** @var Student $student */
            $student = auth('student')->user();

            $advertising = $this->advertisingService->createAdvertising($data, $student, $schoolIds, $files);

            DB::commit();

            return $this->responseSuccess($this->transform($advertising, AdvertisingTransformer::class, $request));
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
        $data = $request->only(['title', 'short_content', 'content', 'area_id', 'advertising_category_id', 'intent_id', 'address', 'price']);

        DB::beginTransaction();
        try {
            $advertising = $this->repository->find($identifier);

            $schoolIds = $request->input('school_ids');

            $file_ids = $request->input('file_ids');

            $files = $request->file('files');

            $advertising = $this->advertisingService->updateAdvertising($advertising, $data, $schoolIds, $file_ids, $files);

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
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy($id, Request $request)
    {
        DB::beginTransaction();
        try {
            /** @var Advertising $advertising */
            $advertising = $this->repository->find($id);

            $advertising->delete();

            DB::commit();
            return $this->responseSuccess('delete advertising success.');
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @param $id
     * @param UpdateStatusAdvertisingRequest $request
     */
    public function updateStatus($id, UpdateStatusAdvertisingRequest $request)
    {
        /** @var Advertising $advertising */
        $advertising = $this->repository->find($id);

        $advertising->status_id = $request->input('status_id');

        $advertising->save();
    }
}
