<?php

namespace App\Filament\Siswa\Resources;

use App\Filament\Siswa\Resources\AbsensiResource\Pages;
use App\Filament\Siswa\Resources\AbsensiResource\Pages\editAbsen;
use App\Filament\Siswa\Resources\AbsensiResource\RelationManagers;
use App\Models\Absensi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AbsensiResource extends Resource
{
    protected static ?string $model = Absensi::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'Manajemen Absensi';

    protected static ?string $navigationLabel = 'Absensi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\Hidden::make('user_id')
                    ->required()
                    ->default(auth('siswa')->user()->id),
                Forms\Components\DatePicker::make('tanggal')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('kelola')
                    ->icon('heroicon-o-pencil-square')
                    ->url(fn ($record) => editAbsen::getUrl([$record->id])),
            ])
            ->emptyStateHeading('Tida Ada Absen')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListAbsensis::route('/'),
            'create' => Pages\CreateAbsensi::route('/create'),
            'edit' => Pages\EditAbsensi::route('/{record}/edit'),
            'absensi' => Pages\editAbsen::route('/{record}/absensi'),
        ];
    }
}
