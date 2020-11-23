<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function from()
    {
        return $this->hasOne(Currency::class);
    }

    public function to()
    {
        return $this->hasOne(Currency::class);
    }
}
