<?php

namespace App\Filament\Pages;

use App\Models\Afdeling as ModelsAfdeling;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class Afdeling extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static string $view = 'filament.pages.afdeling';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Afdeling';
    protected static ?string $title = 'Manajemen Afdeling';

    // Sembunyikan dari navigasi default karena kita menggunakan custom navigation
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    protected $afdelings;

    public function getHeading(): string
    {
        return '';
    }

    public function getTitle(): string
    {
        return 'Manajemen Afdeling';
    }

    public function mount()
    {
        try {
            $this->afdelings = ModelsAfdeling::orderBy('nama')->get();
            
            if ($this->afdelings->isEmpty()) {
                Notification::make()
                    ->title('Informasi')
                    ->body('Belum ada data afdeling yang tersedia.')
                    ->warning()
                    ->send();
            }
        } catch (\Exception $e) {
            Log::error('Error loading afdeling data: ' . $e->getMessage());
            
            Notification::make()
                ->title('Error')
                ->body('Gagal memuat data afdeling. Silakan coba lagi.')
                ->danger()
                ->send();
                
            $this->afdelings = collect();
        }
    }

    public function getAfdelings()
    {
        return $this->afdelings;
    }

    // Method untuk refresh data
    public function refreshData()
    {
        $this->mount();
        
        Notification::make()
            ->title('Berhasil')
            ->body('Data afdeling telah diperbarui.')
            ->success()
            ->send();
    }

    // Method untuk statistik (bisa digunakan di view)
    public function getAfdelingStats()
    {
        return [
            'total' => $this->afdelings->count(),
            'active' => $this->afdelings->count(), // Semua dianggap aktif untuk sementara
        ];
    }
}
