<?php

namespace App;

 use Illuminate\Database\Eloquent\Model;

class Voucher extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'recipient_id', 'expiry_date', 'used_on', 'offer_id', 'status_id'
    ];

    /**
     * Get the recipient of the voucher.
     */
    public function recipient()
    {
        return $this->belongsTo('App\Recipient');
    }
    /**
     * Get the offer of the voucher.
     */
    public function offer()
    {
        return $this->belongsTo('App\Offer');
    }
    /**
     * Get the status of the voucher.
     */
    public function status()
    {
        return $this->belongsTo('App\Status');
    }
}
