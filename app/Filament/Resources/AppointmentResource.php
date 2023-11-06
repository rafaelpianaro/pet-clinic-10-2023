<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Enums\AppointmentStatus;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->native(false)
                    ->displayFormat('M d, Y')
                    ->closeOnDateSelection()
                    ->required()
                    ->live(),
                Forms\Components\TimePicker::make('start')
                    // ->datalist([
                    //     '09:00',
                    //     '09:30',
                    //     '10:00',
                    //     '10:30',
                    //     '11:00',
                    //     '11:30',
                    //     '12:00',
                    // ])
                    ->required()
                    ->seconds(false)
                    ->displayFormat('h:i A'),
                    // ->minutesStep(10),
                Forms\Components\TimePicker::make('end')
                    ->required()
                    // ->timezone('America/New_York')
                    ->seconds(false)
                    ->displayFormat('h:i A')
                    ->minutesStep(10),
                Forms\Components\Select::make('pet_id')
                    ->relationship('pet', 'name')
                    ->required()
                    ->native(false)
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('description')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->native(false)
                    ->options(AppointmentStatus::class)
                    ->visibleOn(Pages\EditAppointment::class)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pet.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->date('M d, Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('start')
                    ->time('h:i A')
                    ->label('From')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end')
                    ->time('h:i A')
                    ->label('To')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Confirm')
                    ->action(function (Appointment $record) {
                        $record->status = AppointmentStatus::Confirmed;
                        $record->save();
                    })
                    ->visible(fn (Appointment $record) => $record->status == AppointmentStatus::Created)
                    ->color('success')
                    ->icon('heroicon-o-check'),
                Tables\Actions\Action::make('Cancel')
                    ->action(function (Appointment $record) {
                        $record->status = AppointmentStatus::Canceled;
                        $record->save();
                    })
                    ->visible(fn (Appointment $record) => $record->status != AppointmentStatus::Canceled)
                    ->color('danger')
                    ->icon('heroicon-o-x-mark'),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
