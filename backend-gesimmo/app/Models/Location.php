<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    public function document()
    {
        return $this->morphOne(Document::class, 'docable');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function bien()
    {
        return $this->belongsTo(Bien::class);
    }
    public function factures()
    {
        return $this->hasMany(Facture::class);
    }
}
