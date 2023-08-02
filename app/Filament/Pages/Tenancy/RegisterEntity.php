<?php
namespace App\Filament\Pages\Tenancy;

use App\Models\Entity;
use App\Models\EntityStatus;
use App\Models\EntityType;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;

class RegisterEntity extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register Entity';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')
                    ->image()
                    ->imageEditor()
                    ->avatar()
                    ->imageEditorEmptyFillColor('#000000'),
               Grid::make()->schema([
                   TextInput::make('name'),
                   TextInput::make('slug'),
                   Select::make('entity_type_id')
                       ->options(EntityType::all()->pluck('name', 'id'))
                       ->preload()
                       ->searchable(),
                   Select::make('entity_status_id')
                       ->options(EntityStatus::all()->pluck('name', 'id'))
                       ->preload()
                       ->searchable(),
                   TextInput::make('address'),
                   TextInput::make('email'),
                   TextInput::make('phone'),
                   TextInput::make('contact_name'),

                   TextInput::make('desc'),
                   TextInput::make('website'),
                   TextInput::make('comment'),
                   TextInput::make('reg_number'),
               ])
            ]);
    }
    protected function handleRegistration(array $data): Entity
    {
        $entity = Entity::create($data);

        $entity->members()->attach(auth()->user());

        return $entity;
    }
}
