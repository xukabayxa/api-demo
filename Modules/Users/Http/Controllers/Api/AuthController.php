<?php

namespace Modules\Users\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Users\Transformers\UserTransformer;
use Modules\Users\Repositories\UserRepository;

/**
 * Class AuthController
 * @property UserRepository $repository
 * @package Modules\Users\Http\Controllers\Api
 */
class AuthController extends BaseApiController
{

    /**
     * @var UserRepository
     */
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $credentials = request(['email', 'password']);

            if (!$token = auth('admin')->attempt($credentials)) {
                return $this->responseErrors(401);
            }

            $user = auth('admin')->user();

            $response = [
                'token' => $token,
                'user' => $this->transform($user, UserTransformer::class, $request)
            ];

            return $this->responseSuccess($response);
        } catch (\Exception $e) {
            Log::error($e);
            return $this->responseErrors(500, $e->getMessage());
        }
    }

}
