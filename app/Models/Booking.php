<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class Booking extends Model
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'booking_id',
        'user_id',
        'provider_id',
        'service_id',
        'sub_service_id',
        'booking_type',
        'status',
        'user_status',
        'provider_status',
        'cancelled_by',
        'cancel_reason',
        'amount',
        'payment_mode',
        'paid',
        'is_track',
        'distance',
        'travel_time',
        's_address',
        's_latitude',
        's_longitude',
        'd_address',
        'd_latitude',
        'track_distance',
        'track_latitude',
        'track_longitude',
        'd_longitude',
        'assigned_at',
        'schedule_date',
        'schedule_start',
        'schedule_end',
        'person',
        'user_rated',
        'provider_rated',
        'user_review',
        'provider_review',
        'use_wallet',
        'surge',
        'route_key',
        'options',
        'dress_code',
        'additional_information',
        'vehicle_image',
        'vehicle_description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }
}