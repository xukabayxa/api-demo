<?php

namespace Modules\Jobs\Http\Requests;
use App\Http\Requests\ApiBaseRequest;

/**
 * Jobs API Request
 *
 * Class JobCreateApiRequest
 * @package Modules\Api\Http\Requests
 */
class JobUpdateApiRequest extends ApiBaseRequest
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
