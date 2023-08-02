<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

/**
 * @method static upsert(array[] $array, string[] $array1)
 */
class UserStatus extends Model
{
    use HasFactory,SoftDeletes,HasTranslations;
    public array $translatable = ['name'];
    protected $fillable = [
        'code', 'name','variant','active'
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }
}
