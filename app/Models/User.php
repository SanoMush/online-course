<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HashRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HashRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'occupation',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function courses(){
        return $this->belongsToMany(Course::class, 'course_students');
    }

    public function subscribe_transactions(){
        return $this->hasMany(SubscribeTransactions::class);
    }

    public function hasActiveSubscriptions(){
        $latestSubscription = $this->subscribe_transactions()
        ->where('is_paid', true)
        ->latest('updated_at')
        ->first();

        if (!$latestSubscription){
            return false;
        }

        $subscriptionEndDate =Carbon::parse($latestSubscription->subscription_start_date)->addMonths(1);
        return Carbon::now()->lessthanEqualTo($subscriptionEndDate);
    }
}
