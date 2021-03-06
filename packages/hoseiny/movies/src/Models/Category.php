<?php

namespace Hoseiny\Movies\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['movie_category_id', 'name'];
}
