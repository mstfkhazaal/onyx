<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

/**
 * @method static upsert(array[] $array, string[] $array1)
 * @method static create(array $data)
 */
class Entity extends Model
{
    use HasFactory, SoftDeletes;
    use HasTranslations;

    public array $translatable = ['name'];
    protected $fillable = [
        'name',
        'slug',
        'entity_type_id',
        'entity_status_id',
        'address',
        'email',
        'phone',
        'contact_name',
        'logo',
        'admin_id',
        'desc',
        'website',
        'comment',
        'reg_number'
    ];
    public function admin(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function entityType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EntityType::class);
    }
    public function entityStatus(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EntityStatus::class);
    }
}
