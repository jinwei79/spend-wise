<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
<<<<<<< HEAD

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
=======
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
>>>>>>> 7f4954b (Updated Chatbot)

    /**
     * The attributes that are mass assignable.
     *
<<<<<<< HEAD
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
=======
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'first_name',
        'last_name',
        'email',
        'password',
        'birthday',
        'salary',
        'profile_photo_path',
>>>>>>> 7f4954b (Updated Chatbot)
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
<<<<<<< HEAD
     * @var list<string>
=======
     * @var array<int, string>
>>>>>>> 7f4954b (Updated Chatbot)
     */
    protected $hidden = [
        'password',
        'remember_token',
<<<<<<< HEAD
=======
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_path',
>>>>>>> 7f4954b (Updated Chatbot)
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
<<<<<<< HEAD
=======
            'budget_notice_dismissed_at' => 'datetime',
>>>>>>> 7f4954b (Updated Chatbot)
        ];
    }
}
