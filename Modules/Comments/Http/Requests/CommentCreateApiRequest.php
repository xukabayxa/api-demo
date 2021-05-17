<?php

namespace Modules\Comments\Http\Requests;
use App\Http\Requests\ApiBaseRequest;

/**
 * Comments API Request
 *
 * Class CommentCreateApiRequest
 * @package Modules\Api\Http\Requests
 */
class CommentCreateApiRequest extends ApiBaseRequest
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
        return [];
    }
}
