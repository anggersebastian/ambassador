<?php
namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Myshortcart extends Model{

    use SoftDeletes;

    protected $table = 'myshortcart';
}