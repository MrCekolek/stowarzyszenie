<?php

namespace App\Models;

use App\Traits\Locable;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject {
    use Notifiable, Locable;

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
        'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'birthdate' => 'date:Y-m-d'
    ];

    protected $appends = [
        'name'
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

    public function getCreatedAtAttribute($value) {
        return $this->localize($value)->toDateTimeString();
    }

    public function getUpdatedAtAttribute($value) {
        return $this->localize($value)->toDateTimeString();
    }

    public function getEmailVerifiedAtAttribute($value) {
        return $this->localize($value)->toDateTimeString();
    }

    public function getNameAttribute() {
        return $this['first_name'] . ' ' . $this['last_name'];
    }

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setBirthdateAttribute($value) {
        $birthdateExploded = explode('/', $value);

        $this->attributes['birthdate'] = Carbon::createFromFormat('d-m-Y', $birthdateExploded[0] . '-' . $birthdateExploded[1] . '-' . $birthdateExploded[2]);
    }

    public function preferenceUser() {
        return $this->hasOne(PreferenceUser::class);
    }

    public function affilationUser() {
        return $this->hasOne(AffiliationUser::class);
    }

    public function roles() {
        return $this->belongsToMany(Role::class)
            ->using(RoleUser::class);
    }

    public function portfolio() {
        return $this->hasOne(Portfolio::class);
    }

    public function interests() {
        return $this->belongsToMany(Interest::class)
            ->using(InterestUser::class);
    }

    public function conferences() {
        return $this->belongsToMany(Conference::class)
            ->using(ConferenceUser::class);
    }
}
