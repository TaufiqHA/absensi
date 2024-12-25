<?php

namespace App\Filament\Resources\KelasResource\Pages;

use App\Models\kelas;
use App\Models\siswa;
use Filament\Resources\Pages\Page;
use App\Filament\Resources\KelasResource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class editSiswaKelas extends Page implements HasTable
{
    use InteractsWithTable;
    protected static string $resource = KelasResource::class;
    protected static ?string $title = 'Edit Siswa';

    protected static string $view = 'filament.resources.kelas-resource.pages.edit-siswa-kelas';

    public $kelas;

    public function mount($record): void
    {
        $this->kelas = kelas::where('id', $record)->first();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(siswa::query()->where('kelas_id', $this->kelas->id))
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Siswa'),
                TextColumn::make('email'),
                TextColumn::make('nis')
                    ->label('NIS')
            ]);
    }
}