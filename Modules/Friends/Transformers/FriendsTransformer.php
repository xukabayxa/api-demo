<?php
namespace Modules\Friends\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Modules\Friends\Entities\Friends;

class FriendsTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    public function transform(Friends $friends)
    {
        return [
            'id' => $friends->id,
            'created_at' => Carbon::parse($friends->localize('created_at'))->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($friends->localize('updated_at'))->format('Y-m-d H:i:s'),
        ];
    }
}