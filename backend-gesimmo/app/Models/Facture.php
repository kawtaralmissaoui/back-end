<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;
    public function document()
    {
        return $this->morphOne(Document::class, 'docable');
    }
    public function location()
    {
        return $this->belongsTo(Facture::class);
    }
}
