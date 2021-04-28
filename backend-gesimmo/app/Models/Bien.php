<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    use HasFactory;
    protected $fillable = [
        'statut',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
