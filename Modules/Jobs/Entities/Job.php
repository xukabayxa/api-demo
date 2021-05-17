<?php

namespace Modules\Jobs\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Advertisings\Entities\AdvertisingStatus;
use Modules\Advertisings\Helpers\AdvertisingCategoryHelper;
use Modules\Areas\Entities\Traits\HasAreaTrait;
use Modules\Comments\Entities\Traits\HasCommentTrait;
use Modules\Customers\Entities\Student;
use Modules\Files\Entities\Traits\HasFileTrait;
use Modules\Jobs\Helpers\JobCategoryHelper;
use Modules\Schools\Entities\School;
use Modules\Users\Entities\User;

/**
 * Class Advertising
 * @property int $id
 * @package Modules\Advertisings\Entities
 *
 * @property string $title
 * @property string $short_content
 * @property string $content
 * @property int $area_id
 * @property int $intent_id
 * @property int $status_id
 * @property int $price
 * @property string $address
 * @property int $job_category_id
 * @property int $creatable_id
 * @property string $creatable_type
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $expiration_date
 *
 * Relations
 * @property-read Collection|School[] $schools
 * @property-read JobIntent $intent
 * @property-read JobStatus $status
 * @property-read JobCategory $category
 * @property-read User|Student $creatable
 *
 * Accessors
 * @property-read array $parent_category
 */
class Job extends Model
{
    use HasAreaTrait, HasFileTrait, HasCommentTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'short_content', 'content', 'job_category_id', 'area_id', 'intent_id', 'address', 'salary', 'type', 'expiration_date', 'creatable_id', 'creatable_type', 'status_id'];

    protected $dates = ['created_at', 'updated_at', 'expiration_date'];

    public static function boot()
    {
        parent::boot();

        self::deleting(function (self $job) {
            $job->schools()->detach();
            $job->comments()->delete();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|JobIntent
     */
    public function intent()
    {
        return $this->belongsTo(JobIntent::class, 'intent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|AdvertisingStatus
     */
    public function status()
    {
        return $this->belongsTo(JobStatus::class, 'status_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|School[]
     */
    public function schools()
    {
        return $this->belongsToMany(School::class, 'job_school', 'job_id', 'school_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|JobCategory
     */
    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo|User|Student
     */
    public function creatable()
    {
        return $this->morphTo();
    }

    /**
     * @return array
     */
    public function getParentCategoryAttribute()
    {
        $categoriesIds = [];
        $categories = [];

        JobCategoryHelper::getParentCategory($this->job_category_id, $categoriesIds);

        krsort($categoriesIds);

        foreach ($categoriesIds as $value) {
            $category = JobCategory::query()->find($value);
            $categories[] = ['id' => $category->id, 'name' => $category->name];
        }

        return !empty($categories)
            ? $categories
            : ['id' => $this->advertising_category_id, 'name' => JobCategory::query()->find($this->advertising_category_id)->value('name')];
    }
}
