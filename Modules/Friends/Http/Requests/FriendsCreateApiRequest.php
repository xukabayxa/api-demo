<?php

namespace Modules\Friends\Http\Requests;
use App\Http\Requests\ApiBaseRequest;

/**
 * Friends API Request
 *
 * Class FriendsCreateApiRequest
 * @package Modules\Api\Http\Requests
 */
class FriendsCreateApiRequest extends ApiBaseRequest
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
