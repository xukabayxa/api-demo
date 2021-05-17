<?php

namespace Modules\Motels\Http\Requests;

use App\Http\Requests\ApiBaseRequest;

/**
 * Motels API Request
 *
 * Class UpdateCommentMotelRequest
 * @package Modules\Api\Http\Requests
 */
class UpdateCommentMotelRequest extends ApiBaseRequest
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
            'comment_id' => 'exists:comments,id',
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all();
        $data['motel_id'] = $this->route('id');
        $data['comment_id'] = $this->route('commentId');
        return $data;
    }
}
