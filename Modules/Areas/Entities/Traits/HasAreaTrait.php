<?php

namespace Modules\Areas\Entities\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Areas\Entities\Area;

/**
 * Trait Areas
 * @package Modules\Areas\Entities\Traits
 * @mixin Model
 *
 * Relations
 * @property-read Area $area
 */
trait HasAreaTrait
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Area
     */
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
}
