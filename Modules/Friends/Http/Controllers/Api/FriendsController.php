<?php

namespace Modules\Friends\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Friends\Http\Requests\FriendsCreateApiRequest;
use Modules\Friends\Http\Requests\FriendsUpdateApiRequest;
use Modules\Friends\Repositories\FriendsRepository;
use Modules\Friends\Transformers\FriendsTransformer;


/**
 * Class FriendsController
 * @property FriendsRepository $repository
 * @package Modules\Friends\Http\Controllers\Api
 */
class FriendsController extends BaseApiController
{
    /**
     * FriendsController constructor.
     * @param FriendsRepository $repository
     */
    public function __construct(FriendsRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @OA\Get(
     *     path="/friends",
     *     summary="Display a listing of the friends",
     *     tags={"Friends"},
     *     operationId="list-friends",
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
        return $this->responseSuccess($this->transform($data, FriendsTransformer::class, $request));
    }

    /**
     * @OA\Get(
     *     path="/friends/{id}",
     *     summary="Display a friends",
     *     tags={"Friends"},
     *     operationId="show-friends",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Numeric ID of the friends",
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
        return $this->responseSuccess($this->transform($entity, FriendsTransformer::class, $request));
    }

    /**
     * @OA\Post(
     *     path="/friends",
     *     summary="Create new a friends",
     *     tags={"Friends"},
     *     operationId="create-new-friends",
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
     * @param FriendsCreateApiRequest $request
     * @return JsonResponse
     */
    public function store(FriendsCreateApiRequest $request)
    {
        DB::beginTransaction();
        try {
            $storeValues = $request->only([]);
            $entity = $this->repository->create($storeValues);
            DB::commit();
            return $this->responseSuccess($this->transform($entity, FriendsTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @OA\Put(
     *     path="/friends/{id}",
     *     summary="Update a friends",
     *     tags={"Friends"},
     *     operationId="update-friends",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Numeric ID of the friends",
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
     * @param FriendsUpdateApiRequest $request
     * @return JsonResponse
     */
    public function update($identifier, FriendsUpdateApiRequest $request)
    {
        $entity = $this->repository->find($identifier);
        $storeValues = $request->only([]);
        DB::beginTransaction();
        try {
            $entity = $this->repository->update($storeValues, $entity->id);
            DB::commit();
            return $this->responseSuccess($this->transform($entity, FriendsTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }
}
