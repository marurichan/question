<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'tag_category_id',
        'title',
        'content'
    ];

    public function comment()
    {
        return $this->hasOne('App\Models\comment');
    }

    public function tagCategory()
    {
        return $this->belongsTo('App\Models\tagCategory');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
    
}
