<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'bien_id'
    ];

    public function bien()
    {
        return $this->belongsTo(Bien::class);
    }
}
