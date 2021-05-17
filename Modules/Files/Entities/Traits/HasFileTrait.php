<?php

namespace Modules\Files\Entities\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Areas\Entities\Area;
use Modules\Files\Entities\File;

/**
 * Trait Files
 * @package Modules\Files\Entities\Traits
 * @mixin Model
 *
 * Relations
 * @property-read Collection|File[] $files
 */
trait HasFileTrait
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany|File
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
