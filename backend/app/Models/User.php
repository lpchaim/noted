<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

enum UserAbility: string
{
    case NotesCreate = 'notes:create';
    case NotesRead = 'notes:read';
    case NotesUpdate = 'notes:update';
    case NotesRemove = 'notes:remove';
}

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public static string|Ability $Ability = Ability::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function abilities(): string|UserAbility
    {
        return UserAbility::class;
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
