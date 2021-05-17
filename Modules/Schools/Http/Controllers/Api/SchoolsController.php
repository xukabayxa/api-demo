<?php

namespace Modules\Schools\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Schools\Http\Requests\SchoolCreateApiRequest;
use Modules\Schools\Http\Requests\SchoolUpdateApiRequest;
use Modules\Schools\Repositories\SchoolRepository;
use Modules\Schools\Transformers\SchoolTransformer;


/**
 * Class SchoolsController
 * @property SchoolRepository $repository
 * @package Modules\Schools\Http\Controllers\Api
 */
class SchoolsController extends BaseApiController
{
    /**
     * SchoolsController constructor.
     * @param SchoolRepository $repository
     */
    public function __construct(SchoolRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @OA\Get(
     *     path="/schools",
     *     summary="Display a listing of the schools",
     *     tags={"School"},
     *     operationId="list-schools",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Số item trả về ở mỗi trang, mặc định là 15",
     *         @OA\Schema(
     *              type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Giá trị trang muốn lấy dữ liệu về, mặc định là 1",
     *         @OA\Schema(
     *              type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $data = $this->repository->paginate(intval($request->get('per_page')));
        return $this->responseSuccess($this->transform($data, SchoolTransformer::class, $request));
    }

    /**
     * @OA\Get(
     *     path="/schools/{id}",
     *     summary="Display a school",
     *     tags={"School"},
     *     operationId="show-school",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Numeric ID of the school",
     *         required=true,
     *         @OA\Schema(
     *              type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     * @param $identifier
     * @param Request $request
     * @return JsonResponse
     */
    public function show($identifier, Request $request)
    {
        $entity = $this->repository->find($identifier);
        return $this->responseSuccess($this->transform($entity, SchoolTransformer::class, $request));
    }

    /**
     * @OA\Post(
     *     path="/schools",
     *     summary="Create new a school",
     *     tags={"School"},
     *     operationId="create-new-school",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *           @OA\MediaType(
     *               mediaType="application/json",
     *               @OA\Schema(
     *                  @OA\Property(
     *                      property="name",
     *                      type="string",
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     * @param SchoolCreateApiRequest $request
     * @return JsonResponse
     */
    public function store(SchoolCreateApiRequest $request)
    {
        DB::beginTransaction();
        try {
            $storeValues = $request->only([]);
            $entity = $this->repository->create($storeValues);
            DB::commit();
            return $this->responseSuccess($this->transform($entity, SchoolTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @OA\Put(
     *     path="/schools/{id}",
     *     summary="Update a school",
     *     tags={"School"},
     *     operationId="update-school",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Numeric ID of the school",
     *         required=true,
     *         @OA\Schema(
     *              type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *           @OA\MediaType(
     *               mediaType="application/json",
     *               @OA\Schema(
     *                  @OA\Property(
     *                      property="name",
     *                      type="string",
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     * @param $identifier
     * @param SchoolUpdateApiRequest $request
     * @return JsonResponse
     */
    public function update($identifier, SchoolUpdateApiRequest $request)
    {
        $entity = $this->repository->find($identifier);
        $storeValues = $request->only([]);
        DB::beginTransaction();
        try {
            $entity = $this->repository->update($storeValues, $entity->id);
            DB::commit();
            return $this->responseSuccess($this->transform($entity, SchoolTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }
}
