<?php

namespace App\Filament\Resources\KelasResource\Pages;

use Filament\Actions;
use App\Models\Absensi;
use Filament\Notifications\Notification;
use App\Filament\Resources\KelasResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateKelas extends CreateRecord
{
    protected static string $resource = KelasResource::class;

    protected function getRedirectUrl(): string
    {
        $kelas = $this->record->id;
        return tambahKelas::getUrl([$kelas]);
    }

    // public function create()
    // {
    //     $record = $this->record;
    //     $currentTime = now()->toTimeString();
    //     $today = now()->format('l');

    //     // Validasi hari (tidak boleh Sabtu atau Minggu)
    //     if (in_array($today, ['Saturday', 'Sunday'])) {
    //         Notification::make()
    //             ->title('Gagal Absen')
    //             ->body('Absen tidak dapat dilakukan pada hari Sabtu atau Minggu.')
    //             ->warning()
    //             ->send();

    //         throw ValidationException::withMessages([
    //             'general' => 'Absen tidak dapat dilakukan pada hari Sabtu atau Minggu.',
    //         ]);
    //     }

    //     // Logika otomatis untuk jam masuk
    //     if (!$record->jam_masuk && request()->hasFile('foto_masuk')) {
    //         $record->jam_masuk = $currentTime;
    //         $record->foto_masuk = request()->file('foto_masuk')->store('foto_absensi', 'public');

    //         Notification::make()
    //             ->title('Berhasil Absen Masuk')
    //             ->body('Jam masuk Anda berhasil dicatat secara otomatis.')
    //             ->success()
    //             ->send();
    //     }

    //     // Logika otomatis untuk jam keluar
    //     if (!$record->jam_keluar && request()->hasFile('foto_keluar')) {
    //         if (!$record->jam_masuk) {
    //             Notification::make()
    //                 ->title('Gagal Absen')
    //                 ->body('Anda harus melakukan absen masuk terlebih dahulu sebelum absen keluar.')
    //                 ->warning()
    //                 ->send();

    //             throw ValidationException::withMessages([
    //                 'jam_keluar' => 'Absen masuk harus dilakukan terlebih dahulu.',
    //             ]);
    //         }

    //         $record->jam_keluar = $currentTime;
    //         $record->foto_keluar = request()->file('foto_keluar')->store('foto_absensi', 'public');

    //         Notification::make()
    //             ->title('Berhasil Absen Keluar')
    //             ->body('Jam keluar Anda berhasil dicatat secara otomatis.')
    //             ->success()
    //             ->send();
    //     }

    //     // Validasi waktu
    //     if ($record->jam_masuk && $currentTime < '08:00:00') {
    //         Notification::make()
    //             ->title('Gagal Absen')
    //             ->body('Belum waktu untuk absen masuk.')
    //             ->warning()
    //             ->send();

    //         throw ValidationException::withMessages([
    //             'jam_masuk' => 'Belum waktu untuk absen masuk.',
    //         ]);
    //     }

    //     if ($record->jam_keluar && $currentTime < '16:00:00') {
    //         Notification::make()
    //             ->title('Gagal Absen')
    //             ->body('Belum waktu untuk absen keluar. Anda hanya dapat absen keluar setelah jam 16:00.')
    //             ->warning()
    //             ->send();

    //         throw ValidationException::withMessages([
    //             'jam_keluar' => 'Belum waktu untuk absen keluar.',
    //         ]);
    //     }

    //     // Set status 'hadir' hanya jika jam masuk dan jam keluar sudah ada
    //     if ($record->jam_masuk && $record->jam_keluar) {
    //         $record->status = 'hadir';
    //     } else {
    //         $record->status = 'alfa';
    //     }
    // }
}
