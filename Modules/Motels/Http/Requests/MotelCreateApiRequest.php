<?php

namespace Modules\Motels\Http\Requests;

use App\Http\Requests\ApiBaseRequest;

/**
 * Motels API Request
 *
 * Class MotelCreateApiRequest
 * @package Modules\Api\Http\Requests
 */
class MotelCreateApiRequest extends ApiBaseRequest
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
        return [
            'title' => 'required',
            'content' => 'required',
            'area_id' => 'required|exists:areas,id',
            'intent_id' => 'required|exists:motel_intents,id',
            'school_ids' => 'required|array',
            'school_ids.*' => 'exists:schools,id',
            'price' => 'integer',
            'files' => 'array',
            'files.*' => 'max:8192|mimes:jpg,png'
        ];
    }
}
