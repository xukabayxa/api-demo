<?php

namespace Modules\Customers\Http\Requests;
use App\Http\Requests\ApiBaseRequest;

/**
 * Customers API Request
 *
 * Class CustomerCreateApiRequest
 * @package Modules\Api\Http\Requests
 */
class CustomerUpdateApiRequest extends ApiBaseRequest
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
