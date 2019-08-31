<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject {
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login_email',
        'password',
        'first_name',
        'last_name',
        'birthdate',
        'gender',
        'contact_email',
        'phone_number',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setBirthdate($value) {
        $birthdateExploded = explode('/', $value);

        $this->attributes['birthdate'] = Carbon::createFromFormat('d-m-Y', $birthdateExploded[0] . '-' . $birthdateExploded[1] . '-' . $birthdateExploded[2]);
    }

    public function scopeLoginEmail($query, $login_email) {
        return $query->where('login_email', $login_email);
    }

    public function scopeRememberToken($query, $token) {
        return $query->where('remember_token', $token);
    }

    public function scopeEmailVerifiedAt($query, $emailVerifiedAt) {
        return $query->where('email_verified_at', $emailVerifiedAt);
    }

    public function scopeId($query, $id) {
        return $query->where('id', $id);
    }

    public function preferenceUser() {
        return $this->hasOne(PreferenceUser::class);
    }

    public function affilationUser() {
        return $this->hasOne(AffiliationUser::class);
    }
}
