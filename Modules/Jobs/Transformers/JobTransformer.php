<?php

namespace Modules\Jobs\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Modules\Advertisings\Entities\Advertising;
use Modules\Areas\Transformers\AreaTransformer;
use Modules\Comments\Transformers\CommentTransformer;
use Modules\Customers\Entities\Student;
use Modules\Customers\Transformers\StudentTransformer;
use Modules\Files\Transformers\FileTransformer;
use Modules\Jobs\Entities\Job;
use Modules\Motels\Entities\Motel;
use Modules\Schools\Transformers\SchoolTransformer;
use Modules\Users\Entities\User;
use Modules\Users\Transformers\UserTransformer;

class JobTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['comments'];
    protected $defaultIncludes = ['area', 'schools', 'files', 'create_by', 'comments'];

    public function transform(Job $job)
    {
        return [
            'id' => $job->id,
            'title' => $job->title,
            'short_content' => $job->short_content,
            'content' => $job->content,
            'job_category' => $job->category,
            'job_parent_category' => $job->parent_category,
            'intent' => $job->intent,
            'status' => $job->status,
            'address' => $job->address,
            'salary' => $job->price,
            'expiration_date' => $job->expiration_date ? $job->expiration_date->format('Y-m-d') : null,
            'created_at' => $job->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $job->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @param Job $advertising
     * @return \League\Fractal\Resource\Item|\League\Fractal\Resource\Primitive
     */
    public function includeArea(Job $advertising)
    {
        $area = $advertising->area;
        return $area ? $this->item($area, new AreaTransformer()) : $this->primitive(null);
    }

    /**
     * @param Job $advertising
     * @return \League\Fractal\Resource\Collection|\League\Fractal\Resource\Primitive
     */
    public function includeSchools(Job $advertising)
    {
        $schools = $advertising->schools;
        return $schools ? $this->collection($schools, new SchoolTransformer()) : $this->primitive(null);
    }

    /**
     * @param Job $advertising
     * @return \League\Fractal\Resource\Collection|\League\Fractal\Resource\Primitive
     */
    public function includeFiles(Job $advertising)
    {
        $files = $advertising->files;
        return $files ? $this->collection($files, new FileTransformer()) : $this->primitive(null);
    }

    /**
     * @param Job $advertising
     * @return \League\Fractal\Resource\Collection|\League\Fractal\Resource\Primitive
     */
    public function includeComments(Job $advertising)
    {
        $comments = $advertising->comments;
        return $comments ? $this->collection($comments, new CommentTransformer()) : $this->primitive(null);
    }

    /**
     * @param Job $advertising
     * @return \League\Fractal\Resource\Item|\League\Fractal\Resource\Primitive
     */
    public function includeCreateBy(Job $advertising)
    {
        $user = $advertising->creatable;

        if ($user && get_class($user) == User::class) {
            return $this->item($user, new UserTransformer());
        } elseif ($user && get_class($user) == Student::class) {
            return $this->item($user, new StudentTransformer());
        } else {
            return $this->primitive(null);
        }
    }
}
