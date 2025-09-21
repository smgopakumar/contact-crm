<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'representative_name',
        'email',
        'phone',
    ];

    public function contact()
    {
        return $this->morphOne(Contact::class, 'source');
    }
}
