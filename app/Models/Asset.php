<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    protected $fillable=['name','code','uid','image','isactive'];
    protected $table = "assets";
    public function AssetType(){
        return $this->belongsTo(AssetType::class,'uid','id');
    }
}
