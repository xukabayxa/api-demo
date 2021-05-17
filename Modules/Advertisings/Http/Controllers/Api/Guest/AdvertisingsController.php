<?php

namespace Modules\Advertisings\Http\Controllers\Api\Guest;

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
use Modules\Advertisings\Repositories\Criteria\AdvertisingRequestCriteria;
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
            ->pushCriteria(new AdvertisingRequestCriteria($request))
            ->orderBy('created_at', 'desc')
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
     * @return JsonResponse
     */
    public function getAdvertisingLatest(Request $request) {
        $advertisings = $this->repository->orderBy('created_at', 'desc')->paginate(5);

        return $this->responseSuccess($this->transform($advertisings, AdvertisingTransformer::class, $request));
    }
}
