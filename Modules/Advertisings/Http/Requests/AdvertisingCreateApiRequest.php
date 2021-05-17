<?php

namespace Modules\Advertisings\Http\Requests;
use App\Http\Requests\ApiBaseRequest;

/**
 * Advertisings API Request
 *
 * Class AdvertisingCreateApiRequest
 * @package Modules\Api\Http\Requests
 */
class AdvertisingCreateApiRequest extends ApiBaseRequest
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
