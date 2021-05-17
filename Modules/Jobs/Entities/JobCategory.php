<?php

namespace Modules\Jobs\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class JobCategory
 * @property int $id
 * @package Modules\Jobs\Entities
 *
 * @property string $name
 * @property string $slug
 * @property int $parent_id
 *
 * Relations
 * @property-read Collection|Job[] $jobs
 */
class JobCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'slug', 'parent_id'];

    protected $table = 'job_categories';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Job[]
     */
    public function jobs()
    {
        return $this->hasMany(Job::class, 'job_category_id');
    }
}
