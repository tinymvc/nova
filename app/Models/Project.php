<?php

namespace App\Models;

use Spark\Database\Model;
use Spark\Database\QueryBuilder;

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
