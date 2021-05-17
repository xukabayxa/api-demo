<?php

namespace Modules\Advertisings\Http\Requests;
use App\Http\Requests\ApiBaseRequest;
use Illuminate\Validation\Rule;

/**
 * Advertisings API Request
 *
 * Class AdvertisingCategoryCreateApiRequest
 * @package Modules\Api\Http\Requests
 */
class AdvertisingCategoryCreateApiRequest extends ApiBaseRequest
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
        if($this->input('type') == 'parent') {
            $required = 'nullable';
        } else{
            $required = 'required|exists:advertising_categories,id';
        }

        return [
            'name' => 'required',
            'type' => ['required',
                Rule::in(['parent', 'child']),
            ],
            'parent_id' => $required,
        ];
    }
}
