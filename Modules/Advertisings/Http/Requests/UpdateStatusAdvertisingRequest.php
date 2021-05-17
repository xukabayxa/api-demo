<?php

namespace Modules\Advertisings\Http\Requests;

use App\Http\Requests\ApiBaseRequest;

/**
 * Motels API Request
 *
 * Class UpdateStatusAdvertisingRequest
 * @package Modules\Api\Http\Requests
 */
class UpdateStatusAdvertisingRequest extends ApiBaseRequest
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
            'advertising_id' => 'exists:advertisings,id',
            'status_id' => 'exists:advertising_statuses,id',
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all();
        $data['advertising_id'] = $this->route('id');
        return $data;
    }
}
