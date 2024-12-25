<?php

namespace App\Filament\Imports;

use App\Models\siswa;
use Illuminate\Support\Facades\Hash;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;

class SiswaImporter extends Importer
{
    protected static ?string $model = siswa::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('email')
                ->requiredMapping()
                ->rules(['required', 'email']),
            ImportColumn::make('password')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('nis')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('kelas_id')
                ->numeric()
                ->rules(['integer']),
        ];
    }

    public function resolveRecord(): ?siswa
    {
        // return siswa::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'password' => Hash::make($this->data['password']),
        // ]);

        return new siswa();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your siswa import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
