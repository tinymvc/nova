<?php

namespace App\Models;

use Spark\Database\Model;
use Spark\Database\QueryBuilder;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $description
 * @property string $status
 * @property \Spark\Carbon $created_at
 * @property \Spark\Carbon $updated_at
 * 
 * @method static QueryBuilder<static> ownedBy(int $userId)
 */
class Project extends Model
{
    public const STATUSES = [
        'planning' => 'Planning',
        'in_progress' => 'In progress',
        'completed' => 'Completed',
    ];

    protected array $fillable = [
        'user_id',
        'name',
        'description',
        'status',
    ];

    public function scopeOwnedBy(QueryBuilder $query, int $userId): QueryBuilder
    {
        return $query->where('user_id', $userId);
    }
}
