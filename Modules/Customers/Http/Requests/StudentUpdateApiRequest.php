<?php

namespace Modules\Customers\Http\Requests;

use App\Http\Requests\ApiBaseRequest;
use Illuminate\Validation\Rule;

/**
 * Customers API Request
 *
 * Class StudentUpdateApiRequest
 * @package Modules\Api\Http\Requests
 */
class StudentUpdateApiRequest extends ApiBaseRequest
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
            'name' => 'required',
            'address' => 'nullable',
            'student_type_id' => 'required|exists:student_types,id',
            'area_id' => 'required|exists:areas,id',
            'school_id' => 'required_without:school_other_name|exists:schools,id',
            'school_other_name' => 'required_without:school_id',
            'file' => 'max:8192|mimes:jpg,png',
            'file_ids' => 'array',
            'phone' => ['nullable', 'regex:/(0)[0-9]{9}$/']
        ];
    }
}
