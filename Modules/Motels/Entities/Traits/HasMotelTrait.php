<?php

namespace Modules\Motels\Entities\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Motels\Entities\Motel;
use Modules\Schools\Entities\School;

/**
 * Trait Motels
 * @package Modules\Motels
 * @mixin Model
 *
 * Relations
 * @property-read Collection|Motel[] $motels
 */
trait HasMotelTrait
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function motels()
    {
        return $this->morphMany(Motel::class, 'creatable');
    }
}
