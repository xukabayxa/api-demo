<?php

namespace Modules\Comments\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Comments\Http\Requests\CommentCreateApiRequest;
use Modules\Comments\Http\Requests\CommentUpdateApiRequest;
use Modules\Comments\Repositories\CommentRepository;
use Modules\Comments\Transformers\CommentTransformer;


/**
 * Class CommentsController
 * @property CommentRepository $repository
 * @package Modules\Comments\Http\Controllers\Api
 */
class CommentsController extends BaseApiController
{
    /**
     * CommentsController constructor.
     * @param CommentRepository $repository
     */
    public function __construct(CommentRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @OA\Get(
     *     path="/comments",
     *     summary="Display a listing of the comments",
     *     tags={"Comment"},
     *     operationId="list-comments",
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
        return $this->responseSuccess($this->transform($data, CommentTransformer::class, $request));
    }

    /**
     * @OA\Get(
     *     path="/comments/{id}",
     *     summary="Display a comment",
     *     tags={"Comment"},
     *     operationId="show-comment",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Numeric ID of the comment",
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
        return $this->responseSuccess($this->transform($entity, CommentTransformer::class, $request));
    }

    /**
     * @OA\Post(
     *     path="/comments",
     *     summary="Create new a comment",
     *     tags={"Comment"},
     *     operationId="create-new-comment",
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
     * @param CommentCreateApiRequest $request
     * @return JsonResponse
     */
    public function store(CommentCreateApiRequest $request)
    {
        DB::beginTransaction();
        try {
            $storeValues = $request->only([]);
            $entity = $this->repository->create($storeValues);
            DB::commit();
            return $this->responseSuccess($this->transform($entity, CommentTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @OA\Put(
     *     path="/comments/{id}",
     *     summary="Update a comment",
     *     tags={"Comment"},
     *     operationId="update-comment",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Numeric ID of the comment",
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
     * @param CommentUpdateApiRequest $request
     * @return JsonResponse
     */
    public function update($identifier, CommentUpdateApiRequest $request)
    {
        $entity = $this->repository->find($identifier);
        $storeValues = $request->only([]);
        DB::beginTransaction();
        try {
            $entity = $this->repository->update($storeValues, $entity->id);
            DB::commit();
            return $this->responseSuccess($this->transform($entity, CommentTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }
}
