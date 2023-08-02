<?php

namespace Database\Seeders;

use App\Models\EntityStatus;
use App\Models\EntityType;
use App\Models\Gender;
use App\Models\JobTitle;
use App\Models\Nationality;
use App\Models\Organization;
use App\Models\User;
use App\Models\UserStatus;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class EntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EntityStatus::upsert([
            [
                'id' => 1,
                'code' => 'PND',
                'name' => json_encode(['en' => 'Pending', 'ar' => 'قيد الانشاء']),
                'variant' => 'secondary',
            ],
            [
                'id' => 2,
                'code' => 'ACT',
                'name' => json_encode(["en" => "Active", "ar" => "مفعل"]),
                'variant' => 'success',
            ],
            [
                'id' => 3,
                'code' => 'NACT',
                'name' => json_encode(["en" => "Not Active", "ar" => "غير مفعل"]),
                'variant' => 'warning',
            ],
            [
                'id' => 4,
                'code' => 'BLOCK',
                'name' => json_encode(["ar" => "محظور", "en" => "Blocked"]),
                'variant' => 'danger',
            ],
            [
                'id' => 5,
                'code' => 'PAUS',
                'name' => json_encode(["ar" => "متوقف", "en" => "Paused"]),
                'variant' => 'warning',
            ],
            [
                'id' => 6,
                'code' => 'DELT',
                'name' => json_encode(["ar" => "محذوف", "en" => "Deleted"]),
                'variant' => 'danger',
            ],
        ], ['id','code', 'variant', 'name']);
        EntityType::upsert([
            [
                'id' => 1,
                'code' => 'IND',
                'name' => json_encode(['en' => 'Individual', 'ar' => 'قردي']),
                'variant' => 'secondary',
            ],
            [
                'id' => 2,
                'code' => 'CMP',
                'name' => json_encode(['en' => 'Company', 'ar' => 'شركة']),
                'variant' => 'secondary',
            ],
            [
                'id' => 3,
                'code' => 'ORG',
                'name' => json_encode(['en' => 'Organization', 'ar' => 'جمعية']),
                'variant' => 'secondary',
            ],
            [
                'id' =>4,
                'code' => 'Group',
                'name' => json_encode(['en' => 'Group', 'ar' => 'مجموعة']),
                'variant' => 'secondary',
            ],
            [
                'id' =>4,
                'code' => 'SCT',
                'name' => json_encode(['en' => 'Scouting', 'ar' => 'كشافة']),
                'variant' => 'secondary',
            ],
        ], ['id','code', 'variant', 'name']);
    }
}
