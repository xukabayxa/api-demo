<?php

namespace Modules\Comments\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Modules\Comments\Entities\Comment;
use Modules\Customers\Entities\Student;
use Modules\Customers\Transformers\StudentTransformer;
use Modules\Users\Entities\User;
use Modules\Users\Transformers\UserTransformer;

class CommentTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];
    protected $defaultIncludes = ['feed_back','created_by'];

    public function transform(Comment $comment)
    {
        Carbon::setLocale('vi');
        return [
            'id' => $comment->id,
            'content' => $comment->content,
            'parent_id' => $comment->parent_id,
            'time_diff' => $comment->created_at->diffForHumans(Carbon::now()),
            'created_at' => $comment->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $comment->updated_at->format('Y-m-d H:i:s')
        ];
    }

    /**
     * @param Comment $comment
     * @return \League\Fractal\Resource\Collection|\League\Fractal\Resource\Primitive
     */
    public function includeFeedBack(Comment $comment)
    {
        $feedback = Comment::query()->where('parent_id', $comment->id)->get();
        return $feedback ? ($this->collection($feedback, new CommentTransformer())) : $this->primitive(null);
    }

    /**
     * @param Comment $comment
     * @return \League\Fractal\Resource\Item
     */
    public function includeCreatedBy(Comment $comment)
    {
        $user = $comment->creatable;

        if (get_class($user) == User::class) {
            return $this->item($user, new UserTransformer());
        } elseif (get_class($user) == Student::class) {
            return $this->item($user, new StudentTransformer());
        }

    }
}
