<?php

namespace Modules\Advertisings\Entities\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Advertisings\Entities\Advertising;
use Modules\Motels\Entities\Motel;
use Modules\Schools\Entities\School;

/**
 * Trait HasAdvertisingTrait
 * @package Modules\Advertisings\Entities\Traits
 *
 * Relations
 * @property-read Collection|Advertising[] $advertisings
 */
trait HasAdvertisingTrait
{
    /**
     * @return mixed
     */
    public function advertisings()
    {
        return $this->morphMany(Advertising::class, 'creatable');
    }
}
