<?php

namespace Modules\Files\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Files\Http\Requests\FileCreateApiRequest;
use Modules\Files\Http\Requests\FileUpdateApiRequest;
use Modules\Files\Repositories\FileRepository;
use Modules\Files\Transformers\FileTransformer;


/**
 * Class FilesController
 * @property FileRepository $repository
 * @package Modules\Files\Http\Controllers\Api
 */
class FilesController extends BaseApiController
{
    /**
     * FilesController constructor.
     * @param FileRepository $repository
     */
    public function __construct(FileRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @OA\Get(
     *     path="/files",
     *     summary="Display a listing of the files",
     *     tags={"File"},
     *     operationId="list-files",
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
        return $this->responseSuccess($this->transform($data, FileTransformer::class, $request));
    }

    /**
     * @OA\Get(
     *     path="/files/{id}",
     *     summary="Display a file",
     *     tags={"File"},
     *     operationId="show-file",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Numeric ID of the file",
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
        return $this->responseSuccess($this->transform($entity, FileTransformer::class, $request));
    }

    /**
     * @OA\Post(
     *     path="/files",
     *     summary="Create new a file",
     *     tags={"File"},
     *     operationId="create-new-file",
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
     * @param FileCreateApiRequest $request
     * @return JsonResponse
     */
    public function store(FileCreateApiRequest $request)
    {
        DB::beginTransaction();
        try {
            $storeValues = $request->only([]);
            $entity = $this->repository->create($storeValues);
            DB::commit();
            return $this->responseSuccess($this->transform($entity, FileTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @OA\Put(
     *     path="/files/{id}",
     *     summary="Update a file",
     *     tags={"File"},
     *     operationId="update-file",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Numeric ID of the file",
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
     * @param FileUpdateApiRequest $request
     * @return JsonResponse
     */
    public function update($identifier, FileUpdateApiRequest $request)
    {
        $entity = $this->repository->find($identifier);
        $storeValues = $request->only([]);
        DB::beginTransaction();
        try {
            $entity = $this->repository->update($storeValues, $entity->id);
            DB::commit();
            return $this->responseSuccess($this->transform($entity, FileTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }
}
