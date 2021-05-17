<?php

namespace Modules\Comments\Entities\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Comments\Entities\Comment;

/**
 * Trait Comments
 * @package Modules\Comments\Entities\Traits
 * @mixin Model
 *
 * Relations
 * @property-read Collection|Comment[] $comments
 */
trait HasCommentTrait
{
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
