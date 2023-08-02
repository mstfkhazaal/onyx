<?php

namespace App\Filament\Pages\Auth;

use App\Models\Gender;
use App\Models\Nationality;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register;
use Illuminate\Support\Str;

class RegisterEdit extends Register
{
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'first_name' => [
                Str::uuid()->toString()=>[
                    'language'=> app()->getLocale(),
                    'value'=>''
                ]
            ],
            'last_name' => [
                Str::uuid()->toString()=>[
                    'language'=> app()->getLocale(),
                    'value'=>''
                ]
            ]
        ]);
    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getNameFormComponent(),
                TableRepeater::make('first_name')
                    ->required()
                    ->mutateDehydratedStateUsing(function ($state) {
                        $lng = [];
                        foreach ($state as $item) {
                            $lng[$item["language"]] = $item["value"];
                        }
                        return $lng;
                    })
                    ->label('register.first_name')
                    ->translateLabel()
                    ->schema([
                        Select::make('language')
                            ->label('table.language')
                            ->translateLabel()
                            ->hiddenLabel()
                            ->required()
                            ->options(function ($set, $get, $state) {
                                $locales = config('filament-language-switch.locales');
                                $localeNames = [];
                                foreach ($locales as $locale => $localeData) {
                                    $localeNames[$locale] = $localeData['native'];
                                }
                                $arr2 = $get('../../first_name');
                                $selectedLanguages = array_column($arr2, 'language');
                                foreach ($selectedLanguages as $language) {
                                    if (isset($localeNames[$language])) {
                                        if ($language !== $state) {
                                            unset($localeNames[$language]);
                                        }
                                    }
                                }
                                return $localeNames;
                            }),
                        TextInput::make('value')
                            ->label('table.value')
                            ->translateLabel()
                            ->hiddenLabel()
                            ->required(),
                    ])
                    ->columnSpanFull()
                    ->reorderable(false)
                    ->minItems(1)
                    ->maxItems(count(array_keys(config('filament-language-switch.locales')))),
                TableRepeater::make('last_name')
                    ->required()
                    ->mutateDehydratedStateUsing(function ($state) {
                        $lng = [];
                        foreach ($state as $item) {
                            $lng[$item["language"]] = $item["value"];
                        }
                        return $lng;
                    })
                    ->label('register.last_name')
                    ->translateLabel()
                    ->schema([
                        Select::make('language')
                            ->label('table.language')
                            ->translateLabel()
                            ->hiddenLabel()
                            ->required()
                            ->options(function ($set, $get, $state) {
                                $locales = config('filament-language-switch.locales');
                                $localeNames = [];
                                foreach ($locales as $locale => $localeData) {
                                    $localeNames[$locale] = $localeData['native'];
                                }
                                $arr2 = $get('../../last_name');
                                $selectedLanguages = array_column($arr2, 'language');
                                foreach ($selectedLanguages as $language) {
                                    if (isset($localeNames[$language])) {
                                        if ($language !== $state) {
                                            unset($localeNames[$language]);
                                        }
                                    }
                                }
                                return $localeNames;
                            }),
                        TextInput::make('value')
                            ->label('table.value')
                            ->translateLabel()
                            ->hiddenLabel()
                            ->required(),
                    ])
                    ->columnSpanFull()
                    ->reorderable(false)
                    ->minItems(1)
                    ->maxItems(count(array_keys(config('filament-language-switch.locales')))),
                Select::make('gender_id')
                    ->label('register.gender')
                    ->translateLabel()
                    ->getSearchResultsUsing(fn (string $search): array => Gender::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id')->toArray())
                    ->getOptionLabelUsing(fn ($value): ?string => Gender::find($value)?->name)
                    ->searchable()
                    ->required(),
                Select::make('nationality_id')
                    ->label('register.nationality')
                    ->translateLabel()
                    ->getSearchResultsUsing(fn (string $search): array => Nationality::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id')->toArray())
                    ->getOptionLabelUsing(fn ($value): ?string => Nationality::find($value)?->name)
                    ->searchable()
                    ->required(),
                Grid::make()->schema([

                ]),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent()
            ])->statePath('data');
    }
}
