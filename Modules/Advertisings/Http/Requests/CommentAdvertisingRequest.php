<?php

namespace Modules\Advertisings\Http\Requests;

use App\Http\Requests\ApiBaseRequest;

/**
 * Motels API Request
 *
 * Class CommentAdvertisingRequest
 * @package Modules\Api\Http\Requests
 */
class CommentAdvertisingRequest extends ApiBaseRequest
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
            'content' => 'required',
            'advertising_id' => 'exists:advertisings,id',
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all();
        $data['advertising_id'] = $this->route('id');
        return $data;
    }
}
