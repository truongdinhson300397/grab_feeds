<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = "items";

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'title',
        'description'
    ];

    protected $guarded = [
        'id'
    ];

    public function categories(){
        return $this->belongsToMany('App\Models\Category','category_item', 'category_id','item_id');
    }
}
