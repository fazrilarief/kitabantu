<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fundraising extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'fundraiser_id',
        'category_id',
        'is_active',
        'has_finished',
        'name',
        'slug',
        'thumbnail',
        'about',
        'target_amount',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function fundraiser(){
        return $this->belongsTo(Fundraiser::class);
    }
    public function donaturs(){
        return $this->hasMany(Donatur::class)->where('is_paid', 1);
    }

    public function totalReachedAmount(){
        return $this->donatur()->sum('total_amount');
    }

    public function withdrawls(){
        return $this->hasMany(FundraisingWithdrawl::class);
    }
}