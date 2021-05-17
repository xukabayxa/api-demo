<?php

namespace Modules\Areas\Http\Requests;
use App\Http\Requests\ApiBaseRequest;

/**
 * Areas API Request
 *
 * Class AreaCreateApiRequest
 * @package Modules\Api\Http\Requests
 */
class AreaCreateApiRequest extends ApiBaseRequest
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
