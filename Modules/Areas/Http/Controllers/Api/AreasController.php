<?php

namespace Modules\Areas\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Areas\Http\Requests\AreaCreateApiRequest;
use Modules\Areas\Http\Requests\AreaUpdateApiRequest;
use Modules\Areas\Repositories\AreaRepository;
use Modules\Areas\Transformers\AreaTransformer;


/**
 * Class AreasController
 * @property AreaRepository $repository
 * @package Modules\Areas\Http\Controllers\Api
 */
class AreasController extends BaseApiController
{
    /**
     * AreasController constructor.
     * @param AreaRepository $repository
     */
    public function __construct(AreaRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @OA\Get(
     *     path="/areas",
     *     summary="Display a listing of the areas",
     *     tags={"Area"},
     *     operationId="list-areas",
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
        return $this->responseSuccess($this->transform($data, AreaTransformer::class, $request));
    }

    /**
     * @OA\Get(
     *     path="/areas/{id}",
     *     summary="Display a area",
     *     tags={"Area"},
     *     operationId="show-area",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Numeric ID of the area",
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
        return $this->responseSuccess($this->transform($entity, AreaTransformer::class, $request));
    }

    /**
     * @OA\Post(
     *     path="/areas",
     *     summary="Create new a area",
     *     tags={"Area"},
     *     operationId="create-new-area",
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
     * @param AreaCreateApiRequest $request
     * @return JsonResponse
     */
    public function store(AreaCreateApiRequest $request)
    {
        DB::beginTransaction();
        try {
            $storeValues = $request->only([]);
            $entity = $this->repository->create($storeValues);
            DB::commit();
            return $this->responseSuccess($this->transform($entity, AreaTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @OA\Put(
     *     path="/areas/{id}",
     *     summary="Update a area",
     *     tags={"Area"},
     *     operationId="update-area",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Numeric ID of the area",
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
     * @param AreaUpdateApiRequest $request
     * @return JsonResponse
     */
    public function update($identifier, AreaUpdateApiRequest $request)
    {
        $entity = $this->repository->find($identifier);
        $storeValues = $request->only([]);
        DB::beginTransaction();
        try {
            $entity = $this->repository->update($storeValues, $entity->id);
            DB::commit();
            return $this->responseSuccess($this->transform($entity, AreaTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }
}
