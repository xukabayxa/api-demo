<?php

namespace Modules\Motels\Http\Controllers\Api\Student;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Customers\Entities\Student;
use Modules\Motels\Entities\Motel;
use Modules\Motels\Entities\MotelStatus;
use Modules\Motels\Http\Requests\DeleteMotelRequest;
use Modules\Motels\Http\Requests\MotelCreateApiRequest;
use Modules\Motels\Http\Requests\MotelUpdateApiRequest;
use Modules\Motels\Http\Requests\UpdateStatusMotelRequest;
use Modules\Motels\Repositories\Criteria\MyMotelCriteria;
use Modules\Motels\Repositories\MotelRepository;
use Modules\Motels\Service\MotelService;
use Modules\Motels\Transformers\MotelTransformer;


/**
 * Class MotelsController
 * @property MotelRepository $repository
 * @package Modules\Motels\Http\Controllers\Api
 */
class MotelsController extends BaseApiController
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
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function index(Request $request)
    {
        $motels = $this->repository->with(['comments','comments.creatable','creatable'])
            ->pushCriteria(new MyMotelCriteria())
            ->orderBy('created_at', 'desc')
            ->paginate(intval($request->get('per_page')));

        return $this->responseSuccess($this->transform($motels, MotelTransformer::class, $request));
    }

    /**
     * @param $identifier
     * @param Request $request
     * @return JsonResponse
     */
    public function show($identifier, Request $request)
    {
        $motel = $this->repository->find($identifier);

        return $this->responseSuccess($this->transform($motel, MotelTransformer::class, $request));
    }

    /**
     * @param MotelCreateApiRequest $request
     * @return JsonResponse
     */
    public function store(MotelCreateApiRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->only(['title', 'short_content', 'content', 'area_id', 'intent_id', 'address', 'price']);
            $data['status_id'] = MotelStatus::OPEN;

            $files = $request->file('files');

            $schoolIds = $request->input('school_ids');

            /** @var Student $student */
            $student = auth('student')->user();

            /** @var Motel $motel */
            $motel = $this->motelService->createMotel($data, $student, $schoolIds, $files);

            DB::commit();

            return $this->responseSuccess($this->transform($motel, MotelTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @param $identifier
     * @param MotelUpdateApiRequest $request
     * @return JsonResponse
     */
    public function update($identifier, MotelUpdateApiRequest $request)
    {
        $data = $request->only(['title', 'short_content', 'content', 'area_id', 'intent_id', 'address', 'price']);

        DB::beginTransaction();
        try {
            $motel = $this->repository->find($identifier);

            $schoolIds = $request->input('school_ids');

            $file_ids = $request->input('file_ids');

            $files = $request->file('files');

            $motel = $this->motelService->updateMotel($motel, $data, $schoolIds, $file_ids, $files);

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
     * @param DeleteMotelRequest $request
     * @return JsonResponse
     */
    public function destroy($id, DeleteMotelRequest $request)
    {
        DB::beginTransaction();
        try {
            /** @var Motel $motel */
            $motel = $this->repository->find($id);

            $motel->delete();

            DB::commit();
            return $this->responseSuccess([],200,'delete motel success.');
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @param $id
     * @param UpdateStatusMotelRequest $request
     * @return JsonResponse
     */
    public function updateStatus($id, UpdateStatusMotelRequest $request)
    {
        /** @var Motel $motel */
        $motel = $this->repository->find($id);

        $motel->status_id = $request->input('status_id');

        $motel->save();

        return $this->responseSuccess($this->transform($motel, MotelTransformer::class, $request));
    }
}
