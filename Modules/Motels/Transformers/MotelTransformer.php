<?php

namespace Modules\Motels\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Modules\Areas\Transformers\AreaTransformer;
use Modules\Comments\Transformers\CommentTransformer;
use Modules\Customers\Entities\Student;
use Modules\Customers\Transformers\StudentTransformer;
use Modules\Files\Transformers\FileTransformer;
use Modules\Motels\Entities\Motel;
use Modules\Schools\Transformers\SchoolTransformer;
use Modules\Users\Entities\User;
use Modules\Users\Transformers\UserTransformer;

class MotelTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['comments'];
    protected $defaultIncludes = ['area', 'schools', 'files', 'creat_by'];

    public function transform(Motel $motel)
    {
        return [
            'id' => $motel->id,
            'title' => $motel->title,
            'short_content' => $motel->short_content,
            'content' => $motel->content,
            'intent_id' => $motel->intent_id,
            'address' => $motel->address,
            'price' => $motel->price,
            'status' => $motel->status,
            'total_comment' => $motel->comments()->count(),
        ];
    }

    /**
     * @param Motel $motel
     * @return \League\Fractal\Resource\Item|\League\Fractal\Resource\Primitive
     */
    public function includeArea(Motel $motel)
    {
        $area = $motel->area;
        return $area ? $this->item($area, new AreaTransformer()) : $this->primitive(null);
    }

    /**
     * @param Motel $motel
     * @return \League\Fractal\Resource\Collection|\League\Fractal\Resource\Primitive
     */
    public function includeSchools(Motel $motel)
    {
        $schools = $motel->schools;
        return $schools ? $this->collection($schools, new SchoolTransformer()) : $this->primitive(null);
    }

    /**
     * @param Motel $motel
     * @return \League\Fractal\Resource\Collection|\League\Fractal\Resource\Primitive
     */
    public function includeFiles(Motel $motel)
    {
        $files = $motel->files;
        return $files ? $this->collection($files, new FileTransformer()) : $this->primitive(null);
    }

    /**
     * @param Motel $motel
     * @return \League\Fractal\Resource\Collection|\League\Fractal\Resource\Primitive
     */
    public function includeComments(Motel $motel)
    {
        $comments = $motel->comments;
        return $comments ? $this->collection($comments, new CommentTransformer()) : $this->primitive(null);
    }

    /**
     * @param Motel $motel
     * @return \League\Fractal\Resource\Item|\League\Fractal\Resource\Primitive
     */
    public function includeCreatBy(Motel $motel)
    {
        $user = $motel->creatable;

        if (get_class($user) == User::class) {
            return $this->item($user, new UserTransformer());
        } elseif (get_class($user) == Student::class) {
            return $this->item($user, new StudentTransformer());
        } else {
            return $this->primitive(null);
        }

    }
}
