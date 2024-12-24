<?php

namespace App\Filament\Resources\KelasResource\Pages;

use App\Models\kelas;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use App\Filament\Resources\KelasResource;
use App\Models\siswa;
use Filament\Forms\Concerns\InteractsWithForms;

class tambahKelas extends Page implements HasForms
{
    use InteractsWithForms;
    protected static string $resource = KelasResource::class;
    protected static ?string $title = 'Tambah Siswa';

    protected static string $view = 'filament.resources.kelas-resource.pages.tambah-kelas';

    public ?array $data = [];

    public $kelas;
    
    public function mount($record): void
    {
        $this->kelas = kelas::where('id', $record)->first();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('siswa')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->label('Nama'),
                        TextInput::make('email')
                            ->required(),
                        TextInput::make('nis')
                            ->required()
                            ->unique('siswas', 'nis') // memastikan NIS unik
                            ->label('NIS'),
                        TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn (string $state): string => Hash::make($state)),
                    ])
                    ->defaultItems(1)
                    ->createItemButtonLabel('Tambah Siswa Baru')
                    ->minItems(1)
                    ->columns(2) // tampilan 2 kolom
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('create')
                ->label('Simpan Semua')
                ->submit('create')
        ];
    }

    public function create(): void
    {
        $data = $this->form->getState();
        
        // Loop through dan simpan setiap siswa
        foreach ($data['siswa'] as $studentData) {
            siswa::create([
                'name' => $studentData['name'],
                'email' => $studentData['email'],
                'nis' => $studentData['nis'],
                'password' => $studentData['password'],
                'kelas_id' => $this->kelas->id,
            ]);
        }

        Notification::make()
            ->title('Berhasil menambahkan ' . count($data['siswa']) . ' siswa')
            ->success()
            ->send();

        $this->redirect(KelasResource::getUrl());
    }


}
