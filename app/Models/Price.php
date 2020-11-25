<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Builder getByCurrencies($from, $to)
 * @see Price::scopeGetByCurrencies()
 */
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
     * @param Builder $query
     * @param string $from
     * @param string $to
     * @return Builder
     */
    function scopeGetByCurrencies($query, $from, $to)
    {
        return $query->whereHas(
            'from',
            static function (Builder $q) use ($from) {
                $q->where('iso_code', '=', $from);
            }
        )
        ->whereHas(
            'to',
            static function (Builder $q) use ($to) {
                $q->where('iso_code', '=', $to);
            }
        );
    }
}
