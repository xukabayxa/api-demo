<?php

namespace Modules\Files\Http\Requests;
use App\Http\Requests\ApiBaseRequest;

/**
 * Files API Request
 *
 * Class FileCreateApiRequest
 * @package Modules\Api\Http\Requests
 */
class FileCreateApiRequest extends ApiBaseRequest
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
