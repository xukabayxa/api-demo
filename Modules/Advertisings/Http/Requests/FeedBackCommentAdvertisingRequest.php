<?php

namespace Modules\Advertisings\Http\Requests;

use App\Http\Requests\ApiBaseRequest;

/**
 * Motels API Request
 *
 * Class FeedBackCommentAdvertisingRequest
 * @package Modules\Api\Http\Requests
 */
class FeedBackCommentAdvertisingRequest extends ApiBaseRequest
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
            'comment_id' => 'exists:comments,id'
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all();
        $data['advertising_id'] = $this->route('id');
        $data['comment_id'] = $this->route('commentId');
        return $data;
    }
}
