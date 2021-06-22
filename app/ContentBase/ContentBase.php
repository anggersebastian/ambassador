<?php

namespace App\ContentBase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentBase extends Model{
    use SoftDeletes;
    protected $table = 'content_base';
    public $timestamps = true;
}