<?php

namespace App\Filament\Siswa\Resources\AbsensiResource\Pages;

use App\Filament\Siswa\Resources\AbsensiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAbsensis extends ListRecords
{
    protected static string $resource = AbsensiResource::class;
    protected static ?string $title = 'Absensi';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Absensi'),
        ];
    }
}
