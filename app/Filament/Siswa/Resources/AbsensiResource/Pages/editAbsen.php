<?php

namespace App\Filament\Siswa\Resources\AbsensiResource\Pages;

use App\Models\Absensi;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Validation\ValidationException;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Filament\Siswa\Resources\AbsensiResource;

class editAbsen extends Page implements HasForms
{
    use InteractsWithForms;
    protected static string $resource = AbsensiResource::class;

    protected static string $view = 'filament.siswa.resources.absensi-resource.pages.edit-absen';

    public ?array $data = [];

    public $record;

    public function mount($record)
    {
        $this->form->fill(Absensi::where('id', $record)->first()->attributesToArray());
        $this->record = Absensi::where('id', $record)->first();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                DatePicker::make('tanggal')
                    ->required(),
                TextInput::make('jam_masuk')
                    ->readOnly(),
                FileUpload::make('foto_masuk')
                    ->directory('absensi')
                    ->image()
                    ->previewable(),
                TextInput::make('jam_keluar')
                    ->readOnly(),
                FileUpload::make('foto_keluar')
                    ->directory('absensi'),
                TextInput::make('keterangan'),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('create'),
        ];
    }


    public function create()
    {
        $data = $this->form->getState();
        $record = $this->record;
        $currentTime = now()->toTimeString();
        $today = now()->format('l');

        // Validasi hari (tidak boleh Sabtu atau Minggu)
        if (in_array($today, ['Saturday', 'Sunday'])) {
            Notification::make()
                ->title('Gagal Absen')
                ->body('Absen tidak dapat dilakukan pada hari Sabtu atau Minggu.')
                ->warning()
                ->send();

            throw ValidationException::withMessages([
                'general' => 'Absen tidak dapat dilakukan pada hari Sabtu atau Minggu.',
            ]);
        }

        // Logika otomatis untuk jam masuk
        if (!$record->jam_masuk && $data['foto_masuk'] != null) {
            if ($currentTime < '08:00:00') {
                Notification::make()
                    ->title('Gagal Absen')
                    ->body('Belum waktu untuk absen masuk.')
                    ->warning()
                    ->send();
        
                throw ValidationException::withMessages([
                    'jam_masuk' => 'Belum waktu untuk absen masuk.',
                ]);
            }
        
            $record->update([
                'jam_masuk' => $currentTime,
                'foto_masuk' => $data['foto_masuk'],
            ]);
        
            Notification::make()
                ->title('Berhasil Absen Masuk')
                ->body('Jam masuk Anda berhasil dicatat secara otomatis.')
                ->success()
                ->send();
        
            return redirect(AbsensiResource::getUrl());
        }
        
        // Logika otomatis untuk jam keluar
        if (!$record->jam_keluar && $data['foto_keluar'] != null) {
            if (!$record->jam_masuk) {
                Notification::make()
                    ->title('Gagal Absen')
                    ->body('Anda harus melakukan absen masuk terlebih dahulu sebelum absen keluar.')
                    ->warning()
                    ->send();
        
                throw ValidationException::withMessages([
                    'jam_keluar' => 'Absen masuk harus dilakukan terlebih dahulu.',
                ]);
            }
        
            if ($currentTime < '16:00:00') {
                Notification::make()
                    ->title('Gagal Absen')
                    ->body('Belum waktu untuk absen keluar. Anda hanya dapat absen keluar setelah jam 16:00.')
                    ->warning()
                    ->send();
        
                throw ValidationException::withMessages([
                    'jam_keluar' => 'Belum waktu untuk absen keluar.',
                ]);
            }
        
            $record->update([
                'jam_keluar' => $currentTime,
                'foto_keluar' => $data['foto_keluar'],
            ]);
        
            Notification::make()
                ->title('Berhasil Absen Keluar')
                ->body('Jam keluar Anda berhasil dicatat secara otomatis.')
                ->success()
                ->send();
        
            return redirect(AbsensiResource::getUrl());
        }        

        // Set status 'hadir' hanya jika jam masuk dan jam keluar sudah ada
        if ($record->jam_masuk && $record->jam_keluar) {
            $record->update([
                'status' => 'hadir',
            ]);
        } elseif ($record->jam_masuk && !$record->jam_keluar) {
            $record->update([
                'status' => false,
            ]);
        } else {
            $record->update([
                'status' => 'alfa'
            ]);
        }
    }

}
