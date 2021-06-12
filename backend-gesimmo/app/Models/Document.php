<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'document',
        'docable_id',
        'docable_type'
    ];

    public function docable()
    {
        return $this->morphTo();
    }
}
