<?php

namespace Modules\Jobs\Http\Requests;

use App\Http\Requests\ApiBaseRequest;
use Illuminate\Validation\Rule;
use Modules\Jobs\Entities\JobIntent;

/**
 * Motels API Request
 *
 * Class MotelCreateApiRequest
 * @package Modules\Api\Http\Requests
 */
class JobCreateApiRequest extends ApiBaseRequest
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
        if($this->input('intent_id') == JobIntent::SEARCH) {
            $required = 'nullable';
        }
        return [
            'title' => 'required',
            'content' => 'required',
            'area_id' => 'required|exists:areas,id',
            'intent_id' => 'required|exists:job_intents,id',
            'school_ids' => 'nullable|array',
            'school_ids.*' => 'exists:schools,id',
            'salary' => 'nullable|integer',
            'job_category_id' => 'required|exists:job_categories,id',
            'files' => 'array',
            'files.*' => 'max:8192|mimes:jpg,png',
            'type' => ['required',
                Rule::in(['parttime', 'fulltime']),
            ],
        ];
    }
}
