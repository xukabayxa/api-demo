<?php

namespace Modules\Files\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Files
 * @package Modules\Files\Entities
 *
 * @property int $id
 * @property string $name
 * @property string $path
 * @property string $path_thumbnail
 * @property string $fileable_id
 * @property string $fileable_type
 */
class File extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'path', 'path_thumbnail', 'fileable_id', 'fileable_type'];

    protected $table = 'files';

}
