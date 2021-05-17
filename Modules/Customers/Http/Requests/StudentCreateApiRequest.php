<?php

namespace Modules\Customers\Http\Requests;
use App\Http\Requests\ApiBaseRequest;
use Illuminate\Validation\Rule;

/**
 * Customers API Request
 *
 * Class StudentCreateApiRequest
 * @package Modules\Api\Http\Requests
 */
class StudentCreateApiRequest extends ApiBaseRequest
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
            'email' => 'required|email:rfc,dns|unique:students,email',
            'password' => 'required|min:6',
            'address' => 'nullable',
            'student_type_id' => 'required|exists:student_types,id',
            'area_id' => 'required|exists:areas,id',
//            'school_id' => 'required_without:school_other_name|exists:schools,id',
//            'school_other_name' => 'required_without:school_id',
            'school_id' => 'exists:schools,id',
            'file' => 'max:8192|mimes:jpg,png',
            'phone' => ['nullable', 'regex:/(0)[0-9]{9}$/']
        ];
    }
}
