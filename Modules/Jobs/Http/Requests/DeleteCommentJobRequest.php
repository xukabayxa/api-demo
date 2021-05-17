<?php

namespace Modules\Jobs\Http\Requests;

use App\Http\Requests\ApiBaseRequest;

/**
 * Motels API Request
 *
 * Class DeleteCommentJobRequest
 * @package Modules\Api\Http\Requests
 */
class DeleteCommentJobRequest extends ApiBaseRequest
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
            'job_id' => 'exists:jobs,id',
            'comment_id' => 'exists:comments,id',
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all();
        $data['job_id'] = $this->route('id');
        $data['comment_id'] = $this->route('commentId');
        return $data;
    }
}
