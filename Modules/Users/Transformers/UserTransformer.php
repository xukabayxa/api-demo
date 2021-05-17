<?php
namespace Modules\Users\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Modules\Users\Entities\User;

class UserTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'is_user' => 'admin',
        ];
    }
}
