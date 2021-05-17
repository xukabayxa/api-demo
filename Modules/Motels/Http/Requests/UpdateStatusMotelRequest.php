<?php

namespace Modules\Motels\Http\Requests;

use App\Http\Requests\ApiBaseRequest;

/**
 * Motels API Request
 *
 * Class UpdateStatusMotelRequest
 * @package Modules\Api\Http\Requests
 */
class UpdateStatusMotelRequest extends ApiBaseRequest
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
            'motel_id' => 'exists:motels,id',
            'status_id' => 'exists:motel_statuses,id',
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all();
        $data['motel_id'] = $this->route('id');
        return $data;
    }
}
