<?php

namespace Modules\Schools\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Areas\Entities\Traits\HasAreaTrait;

/**
 * Class School
 * @property int $id
 * @package Modules\Schools\Entities
 *
 * @property string $name
 * @property int $school_type_id
 * @property string $code
 * @property int $area_id
 *
 * @Relation
 * @property-read SchoolType $schoolType
 */
class School extends Model
{
    use HasAreaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'school_type_id', 'code', 'area_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|SchoolType
     */
    public function schoolType()
    {
        return $this->belongsTo(SchoolType::class, 'school_type_id');
    }
}
