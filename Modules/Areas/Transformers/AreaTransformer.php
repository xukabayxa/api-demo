<?php
namespace Modules\Areas\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Modules\Areas\Entities\Area;

class AreaTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    public function transform(Area $area)
    {
        return [
            'id' => $area->id,
            'name' => $area->name,
            'code' => $area->code,
        ];
    }
}
