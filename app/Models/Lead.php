<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    /**
     * A lead can have many contacts (polymorphic relation).
     */
    public function contacts()
    {
        return $this->morphMany(Contact::class, 'source');
    }
}
