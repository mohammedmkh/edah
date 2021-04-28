<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Laravel\Passport\HasApiTokens;
use Auth;
use Illuminate\Support\Facades\DB;

// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'identity', 'dateOfBirth', 'role', 'image', 'verify', 'otp', 'location', 'address', 'address_id', 'referral_code', 'referral_user', 'phone_code', 'driver_radius',
        'provider', 'provider_token', 'favourite', 'device_token', 'cover_image', 'enable_notification', 'enable_location', 'enable_call', 'friend_code', 'free_order', 'lat', 'lang', 'driver_available',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at', 'shops', 'is_complete_register',
        'registration_code', 'person_code' ,'location' ,'phone_code' ,'address' ,'address_id' ,'email_verified_at'
        , 'device_token' , 'gender' ,'FullAddress'
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['imagePath'];



    public function getImagePathAttribute()
    {
        return url('/') . '/'.$this->image;
    }

    public function findForPassport($username)
    {
        // dd($username );
        $user = $this->where('phone', $username)->first();

        return $user;
    }

    public function techstore()
    {
        return $this->hasOne(TechStoreUser::class, 'user_id', 'id');
    }

    public function techstoreService()
    {
        return $this->hasOne(TechStoreServices::class, 'user_id', 'id');
    }

    public function userOrder()
    {

        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function TechnicianEvaluation()
    {

        return $this->hasMany(UserEvaluation::class, 'technical_id', 'id');
    }

    public function userAddress()
    {

        return $this->hasone(UserAddress::class, 'user_id', 'id');
    }
    public function userRole()
    {

        return $this->belongsTo(role::class, 'role', 'id');
    }
}
