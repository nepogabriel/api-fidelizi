<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prize extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'points'
    ];

    public function redemptions(): HasMany
    {
        return $this->hasMany(Redemption::class);
    }
}
