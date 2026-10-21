<?php

namespace App\Models;

use Spark\Database\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property \Spark\Carbon $created_at
 * @property \Spark\Carbon $updated_at
 */
class User extends Model
{
    protected array $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    protected array $hidden = [
        'password',
        'remember_token',
    ];

    protected array $casts = [
        'password' => 'hashed',
    ];
}
