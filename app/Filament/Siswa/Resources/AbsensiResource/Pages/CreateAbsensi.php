<?php

namespace App\Filament\Siswa\Resources\AbsensiResource\Pages;

use App\Filament\Siswa\Resources\AbsensiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAbsensi extends CreateRecord
{
    protected static string $resource = AbsensiResource::class;
    protected static ?string $title = 'Tambah Absensi';

    protected function getRedirectUrl(): string
    {
        $record = $this->record->id;
        return editAbsen::getUrl([$record]);
    }
}
