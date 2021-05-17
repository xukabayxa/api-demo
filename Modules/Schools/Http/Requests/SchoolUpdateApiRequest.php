<?php

namespace Modules\Schools\Http\Requests;
use App\Http\Requests\ApiBaseRequest;

/**
 * Schools API Request
 *
 * Class SchoolCreateApiRequest
 * @package Modules\Api\Http\Requests
 */
class SchoolUpdateApiRequest extends ApiBaseRequest
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
