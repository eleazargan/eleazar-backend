<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Project
 *
 * @property string title
 * @property string description
 * @property string repo_url
 * @property string demo_url
 *
 * @package App\Models
 */
class Project extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];
}
