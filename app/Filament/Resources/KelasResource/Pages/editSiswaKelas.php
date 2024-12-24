<?php

namespace App\Filament\Resources\KelasResource\Pages;

use App\Filament\Resources\KelasResource;
use Filament\Resources\Pages\Page;

class editSiswaKelas extends Page
{
    protected static string $resource = KelasResource::class;

    protected static string $view = 'filament.resources.kelas-resource.pages.edit-siswa-kelas';
}
