<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function from()
    {
        return $this->hasOne(Currency::class, 'id', 'from');
    }

    public function to()
    {
        return $this->hasOne(Currency::class, 'id', 'to');
    }

    /**
     * @param string $from
     * @param string $to
     * @return Builder
     */
    static function getByCurrencies($from, $to)
    {
        return self::whereHas(
            'from',
            static function ($q) use ($from) {
                $q->where('iso_code', '=', $from);
            }
        )
        ->whereHas(
            'to',
            static function ($q) use ($to) {
                $q->where('iso_code', '=', $to);
            }
        );
    }
}
