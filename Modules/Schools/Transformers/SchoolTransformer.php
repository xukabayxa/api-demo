<?php

namespace Modules\Schools\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Modules\Areas\Transformers\AreaTransformer;
use Modules\Schools\Entities\School;

class SchoolTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];
    protected $defaultIncludes = ['area'];

    public function transform(School $school)
    {
        return [
            'id' => $school->id,
            'name' => $school->name,
            'school_type_id' => $school->school_type_id,
            'code' => $school->code,
        ];
    }

    /**
     * @param School $school
     * @return \League\Fractal\Resource\Item|\League\Fractal\Resource\Primitive
     */
    public function includeArea(School $school)
    {
        $area = $school->area;
        return $area ? $this->item($area, new AreaTransformer()) : $this->primitive(null);
    }
}
