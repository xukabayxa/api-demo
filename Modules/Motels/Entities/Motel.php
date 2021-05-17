<?php

namespace Modules\Motels\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Areas\Entities\Traits\HasAreaTrait;
use Modules\Comments\Entities\Traits\HasCommentTrait;
use Modules\Customers\Entities\Student;
use Modules\Files\Entities\Traits\HasFileTrait;
use Modules\Schools\Entities\School;
use Modules\Schools\Entities\Traits\HasSchoolTrait;
use Modules\Users\Entities\User;

/**
 * Class Motel
 * @property int $id
 * @package Modules\Motels\Entities
 *
 * @property string $title
 * @property string $short_content
 * @property string $content
 * @property int $area_id
 * @property int $intent_id
 * @property int $status_id
 * @property int $price
 * @property string $address
 * @property int $creatable_id
 * @property string $creatable_type
 *
 * Relations
 * @property-read MotelIntent $intent
 * @property-read Collection|School[] $schools
 * @property-read MotelStatus| $status
 * @property-read User|Student $creatable
 */
class Motel extends Model
{
    use HasAreaTrait, HasFileTrait, HasCommentTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'short_content', 'content', 'area_id', 'intent_id', 'address', 'price', 'creatable_id', 'creatable_type', 'status_id'];

    protected $dates = ['created_at', 'updated_at'];

    public static function boot()
    {
        parent::boot();

        self::deleting(function (self $motel) {
            $motel->comments()->delete();
            $motel->schools()->detach();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|MotelIntent
     */
    public function intent()
    {
        return $this->belongsTo(MotelIntent::class, 'intent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|School[]
     */
    public function schools()
    {
        return $this->belongsToMany(School::class, 'motel_school', 'motel_id', 'school_id')->withTimestamps();
    }

    public function status()
    {
        return $this->belongsTo(MotelStatus::class, 'status_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo|User|Student
     */
    public function creatable()
    {
        return $this->morphTo();
    }
}
