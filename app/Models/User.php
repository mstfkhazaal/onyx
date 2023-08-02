<?php

namespace App\Models;

 use Filament\Models\Contracts\HasAvatar;
 use Filament\Models\Contracts\HasDefaultTenant;
 use Filament\Models\Contracts\HasName;
 use Filament\Models\Contracts\HasTenants;
 use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Relations\BelongsToMany;
 use Illuminate\Database\Eloquent\SoftDeletes;
 use Illuminate\Foundation\Auth\User as Authenticatable;
 use Illuminate\Notifications\Notifiable;
 use Laravel\Sanctum\HasApiTokens;
 use Spatie\Permission\Traits\HasRoles;
 use Spatie\Translatable\HasTranslations;

 /**
  * @method static upsert(array[] $array, string[] $array1)
  * @property mixed $profile_photo_path
  * @property mixed $first_name
  * @property mixed $last_name
  * @property mixed $entities
  */
 class User extends Authenticatable implements FilamentUser,MustVerifyEmail,HasTenants,HasAvatar, HasName,HasDefaultTenant
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;
    use SoftDeletes,HasTranslations;
    public array $translatable = [ 'first_name','last_name'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'entity_id',
        'user_status_id',
        'profile_photo_path',
        'first_name',
        'last_name',
        'nationality_id',
        'gender_id',
        'date_of_birth',
        'address',
        'phone',
        'bio',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return  $this->hasVerifiedEmail();
    }
     public function getFilamentAvatarUrl(): ?string
     {
         if ($this->profile_photo_path != null) {
             return '/storage/' . $this->profile_photo_path;
         }
         return null;
     }

     public function getFilamentName(): string
     {
         try {
             return "{$this->first_name} {$this->last_name}";

         } catch (\Exception $e) {
             $frst = array_values($this->first_name)[0];
             $last = array_values($this->last_name)[0];
             return "{$frst} {$last}";

         }
     }
    public function getTenants(Panel $panel): array|\Illuminate\Support\Collection
    {
        //dd( $this->entities);
        return $this->entities;
    }

    public function entities(): BelongsToMany
    {
        return $this->belongsToMany(Entity::class,'entity_users');
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return true;
    }
     public function entity(): \Illuminate\Database\Eloquent\Relations\BelongsTo
     {
         return $this->belongsTo(Entity::class);
     }

     public function gender(): \Illuminate\Database\Eloquent\Relations\BelongsTo
     {
         return $this->belongsTo(Gender::class);
     }


     public function nationality(): \Illuminate\Database\Eloquent\Relations\BelongsTo
     {
         return $this->belongsTo(Nationality::class);
     }

     public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
     {
         return $this->belongsTo(UserStatus::class, 'user_status_id');
     }

     public function getDefaultTenant(Panel $panel): ?Model
     {
        return  Entity::find('entity_id');
     }
 }
