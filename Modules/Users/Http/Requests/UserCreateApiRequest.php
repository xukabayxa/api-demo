<?php

namespace Modules\Users\Http\Requests;
use App\Http\Requests\ApiBaseRequest;

/**
 * Users API Request
 *
 * Class UserCreateApiRequest
 * @package Modules\Api\Http\Requests
 */
class UserCreateApiRequest extends ApiBaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }
}
