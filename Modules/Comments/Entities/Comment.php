<?php

namespace Modules\Comments\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Customers\Entities\Student;
use Modules\Users\Entities\User;

/**
 * Class Comment
 * @property int $id
 * @package Modules\Comments\Entities
 *
 * @property string $content
 * @property int $commentable_id
 * @property string $commentable_type
 * @property int $creatable_id
 * @property string $creatable_type
 * @property int $parent_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * Relations
 * @property-read $creatable
 */
class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'content', 'commentable_id', 'commentable_type', 'creatable_id', 'creatable_type', 'parent_id'];

    protected $dates = ['created_at', 'updated_at'];

    public static function boot()
    {
        parent::boot();

        self::deleting(function (self $announcementComment) {
            $commentsChildIds = [];

            self::findCommentChild($announcementComment->id, $commentsChildIds);

            self::query()->whereIn('id', $commentsChildIds)->delete();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo|User|Student
     */
    public function creatable()
    {
        return $this->morphTo();
    }
    /**
     * @param int $commentId
     * @param array $commentChildIds
     */
    public static function findCommentChild($commentId, &$commentChildIds)
    {
        $commentsChild = [];

        foreach (self::query()->where('parent_id', $commentId)->get() as $item) {
            $commentsChild[] = $item;
        }

        if ($commentsChild) {
            foreach ($commentsChild as $item) {
                array_push($commentChildIds, $item->id);
                self::findCommentChild($item->id, $commentChildIds);
            }
        }

    }
}
