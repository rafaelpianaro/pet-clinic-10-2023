<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PetResource\Pages;
use App\Models\Pet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use App\Enums\PetType;

class PetResource extends Resource
{
    protected static ?string $model = Pet::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([
                    Forms\Components\FileUpload::make('avatar')
                        ->image()
                        ->directory('avatars')
                        ->imageEditor(),
                    Forms\Components\TextInput::make('name')
                        ->required(),
                    Forms\Components\DatePicker::make('date_of_birth')
                        ->native(false)
                        ->required()
                        // ->timezone('America/Sao_Paulo')
                        ->displayFormat('M d Y'),
                    Forms\Components\Select::make('type')
                        ->native(false)
                        ->options(PetType::class),
                        // ->options([
                        //     'dog' => 'Dog',
                        //     'cat' => 'Cat',
                        //     'lizard' => 'Lizard'
                        // ])
                    Forms\Components\Select::make('owner_id')
                        ->relationship('owner', 'name')
                        ->native(false)
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            Forms\Components\Section::make([
                                Forms\Components\TextInput::make('name')
                                    ->required(),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required(),
                                Forms\Components\TextInput::make('phone')
                                    ->tel()
                                    ->mask('999 999 999')
                                    ->required(),
                            ])
                        ])
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date('M d Y')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('owner.name')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (Pet $record) {
                        Storage::delete('public/' . $record->avatar);
                    })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPets::route('/'),
            'create' => Pages\CreatePet::route('/create'),
            'edit' => Pages\EditPet::route('/{record}/edit'),
        ];
    }
}
