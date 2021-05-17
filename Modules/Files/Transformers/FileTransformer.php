<?php
namespace Modules\Files\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Modules\Files\Entities\File;

class FileTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    public function transform(File $file)
    {
        return [
            'id' => $file->id,
            'name' => $file->name,
            'path' => $file->path ? asset('storage/'. $file->path) : null,
            'path_thumbnail' => $file->path_thumbnail ? asset($file->path_thumbnail) : null,
        ];
    }
}
