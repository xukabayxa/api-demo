<?php

namespace Modules\Jobs\Http\Requests;

use App\Http\Requests\ApiBaseRequest;

/**
 * Motels API Request
 *
 * Class CommentJobRequest
 * @package Modules\Api\Http\Requests
 */
class CommentJobRequest extends ApiBaseRequest
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
            'job_id' => 'exists:jobs,id',
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all();
        $data['job_id'] = $this->route('id');
        return $data;
    }
}
