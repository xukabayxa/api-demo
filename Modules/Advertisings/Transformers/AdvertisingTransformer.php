<?php

namespace Modules\Advertisings\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Modules\Advertisings\Entities\Advertising;
use Modules\Areas\Transformers\AreaTransformer;
use Modules\Comments\Transformers\CommentTransformer;
use Modules\Customers\Entities\Student;
use Modules\Customers\Transformers\StudentTransformer;
use Modules\Files\Transformers\FileTransformer;
use Modules\Motels\Entities\Motel;
use Modules\Schools\Transformers\SchoolTransformer;
use Modules\Users\Entities\User;
use Modules\Users\Transformers\UserTransformer;

class AdvertisingTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['comments'];
    protected $defaultIncludes = ['area', 'schools', 'files', 'create_by', 'comments'];

    public function transform(Advertising $advertising)
    {
        return [
            'id' => $advertising->id,
            'title' => $advertising->title,
            'short_content' => $advertising->short_content,
            'content' => $advertising->content,
            'advertising_category' => $advertising->category,
            'advertising_parent_category' => $advertising->parent_category,
            'intent' => $advertising->intent,
            'status' => $advertising->status,
            'address' => $advertising->address,
            'price' => $advertising->price,
            'created_at' => $advertising->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $advertising->updated_at->format('Y-m-d H:i:s')
        ];
    }

    /**
     * @param Advertising $advertising
     * @return \League\Fractal\Resource\Item|\League\Fractal\Resource\Primitive
     */
    public function includeArea(Advertising $advertising)
    {
        $area = $advertising->area;
        return $area ? $this->item($area, new AreaTransformer()) : $this->primitive(null);
    }

    /**
     * @param Advertising $advertising
     * @return \League\Fractal\Resource\Collection|\League\Fractal\Resource\Primitive
     */
    public function includeSchools(Advertising $advertising)
    {
        $schools = $advertising->schools;
        return $schools ? $this->collection($schools, new SchoolTransformer()) : $this->primitive(null);
    }

    /**
     * @param Advertising $advertising
     * @return \League\Fractal\Resource\Collection|\League\Fractal\Resource\Primitive
     */
    public function includeFiles(Advertising $advertising)
    {
        $files = $advertising->files;
        return $files ? $this->collection($files, new FileTransformer()) : $this->primitive(null);
    }

    /**
     * @param Advertising $advertising
     * @return \League\Fractal\Resource\Collection|\League\Fractal\Resource\Primitive
     */
    public function includeComments(Advertising $advertising)
    {
        $comments = $advertising->comments;
        return $comments ? $this->collection($comments, new CommentTransformer()) : $this->primitive(null);
    }

    /**
     * @param Advertising $advertising
     * @return \League\Fractal\Resource\Item|\League\Fractal\Resource\Primitive
     */
    public function includeCreateBy(Advertising $advertising)
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
