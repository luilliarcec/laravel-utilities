<?php

namespace Tests\Utils;

use Illuminate\Database\Eloquent\Model;
use Luilliarcec\Utilities\Concerns\SetAttributesUppercase;

class User extends Model
{
    use SetAttributesUppercase;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected $dontApplyCase = [
        'email'
    ];
}
