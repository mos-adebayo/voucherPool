<?php

namespace App;

 use Illuminate\Database\Eloquent\Model;

class Offer extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'fixed_discount'
    ];

    /**
     * Get the vouchers generated for the offer.
     */
    public function vouchers()
    {
        return $this->hasMany('App\Voucher');
    }

}
