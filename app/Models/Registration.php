<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $appends = ['name', 'digi_text', 'digicash_text'];
    protected $guarded = [];
    private $payment_methods = [
        'Digi', 'Digicash'
    ];

    public function getNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function getDigiTextAttribute()
    {
        return $this->digi ? 'Yes' : 'No';
    }

    public function getDigicashTextAttribute()
    {
        return $this->digicash ? 'Yes' : 'No';
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function cs()
    {
        return $this->belongsTo(User::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function getValidationTextAttribute()
    {
        switch ($this->validation) {
            case 0;
                return 'Menunggu';
            case 1:
                return 'Valid';
            case 2:
                return 'Tidak Valid';
            default:
                return 'unknown';
        }
    }

    public function getValidationColorAttribute()
    {
        switch ($this->validation) {
            case 0;
                return 'warning';
            case 1:
                return 'success';
            case 2:
                return 'danger';
            default:
                return 'primary';
        }
    }

    public function getPaymentMethodTextAttribute()
    {
        return $this->payment_methods[$this->payment_method];
    }
}
