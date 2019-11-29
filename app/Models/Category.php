<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name'
    ];

    protected $guarded = [
        'id'
    ];

    public function items(){
        return $this->belongsToMany('App\Models\Item','category_item', 'category_id','item_id');
    }
}
