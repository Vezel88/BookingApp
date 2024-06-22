<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudioTime extends Model
{

    use HasFactory;

    protected $table = 'studio_time';
    protected $fillable = ['studio_id', 'date', 'start_time', 'end_time', 'price'];

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }


    public function timeSlots()
    {
        return $this->hasMany(StudioTime::class);
    }
}
