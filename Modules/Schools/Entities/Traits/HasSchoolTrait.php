<?php

namespace Modules\Schools\Entities\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Schools\Entities\School;

/**
 * Trait Areas
 * @package Modules\Schools
 * @mixin Model
 *
 * Relations
 * @property-read School $school
 */
trait HasSchoolTrait
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|School
     */
    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}
