<?php

namespace Modules\Customers\Http\Requests;

use App\Http\Requests\ApiBaseRequest;

/**
 * Class StudentUpdatePasswordRequest
 * @package Modules\Customers\Http\Requests
 *
 * @property $current_password
 * @property $new_password
 * @property $password_confirmation
 */
class StudentUpdatePasswordRequest extends ApiBaseRequest
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

    /**
     * @return array|string[]
     */
    public function rules()
    {
        return [
            'current_password' => 'required',
            'new_password' => 'required|min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required|min:6',
        ];
    }
}
