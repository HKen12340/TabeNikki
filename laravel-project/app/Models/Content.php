<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Image;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        "food_name",
        "shop_name",
        "price",
        "visit_date",
        "place",
        "thoughts",
        "user_id",
        "created_at",
        "updated_at"
    ];

    public function Image(){
        return $this->hasOne('App\Models\Image');
    }
}
