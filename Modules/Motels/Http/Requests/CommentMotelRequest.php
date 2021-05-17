<?php

namespace Modules\Motels\Http\Requests;

use App\Http\Requests\ApiBaseRequest;

/**
 * Motels API Request
 *
 * Class CommentMotelRequest
 * @package Modules\Api\Http\Requests
 */
class CommentMotelRequest extends ApiBaseRequest
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
            'motel_id' => 'exists:motels,id',
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all();
        $data['motel_id'] = $this->route('id');
        return $data;
    }
}
