<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Symfony\Contracts\Service\Attribute\Required;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Student';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                TextInput::make('nis')
                    ->Required(),
                TextInput::make('name')
                    ->required(),
                Select::make('gender')
                ->Required()
                    ->options([
                        'male'      => 'Male',
                        'female'    => 'Female',
                    ]),
                DatePicker::make('birthday'),
                Select::make('religion')
                ->Required()
                    ->options([
                       'islam'  => 'Islam',
                       'katolik'    => 'Katolik',
                       'protestan'  => 'Protestan',
                       'hindu'      => 'Hindu',
                       'buddha'     => 'Buddha',
                       'khonghucu'  => 'Khonghucu',
                    ]),
                TextInput::make('contact')
                ->Required(),
                FileUpload::make('profile')
                    ->directory('student')
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')->state(
                    static function ( $livewire, \stdClass $rowLoop): string {
                        return (string) ($rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * ($livewire->getTablePage() - 1
                            ))
                        );
                    }
                ),
                TextColumn::make('nis'),
                TextColumn::make('name'),
                TextColumn::make('gender'),
                TextColumn::make('birthday'),
                TextColumn::make('contact'),
                ImageColumn::make('profile')
                    ->square()
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    } 
    
}
