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
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * Get the vouchers generated for the offer.
     */
    public function vouchers()
    {
        return $this->hasMany('App\Voucher');
    }

}
