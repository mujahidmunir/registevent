<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $dates = ['started_at', 'ended_at'];

    public function getStatusTextAttribute()
    {
        return $this->active ? 'Non-Aktifkan' : 'Aktifkan';
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
