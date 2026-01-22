<?php

namespace Modules\Website\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $fillable = ['email', 'is_subscribed'];

}
