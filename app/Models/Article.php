<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Article
 *
 * @property string title
 * @property string description
 * @property string content
 * @property array tags
 * @package App\Models
 */
class Article extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'tags' => 'array'
    ];
}
