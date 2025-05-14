<?php

namespace App\Filament\Resources\PredictionResource\Pages;

use App\Filament\Resources\PredictionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePrediction extends CreateRecord
{
    protected static string $resource = PredictionResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post('http://localhost:5000/predict', [
                'json' => [
                    'year' => $data['year'],
                    'month' => $data['month']
                ],
                'timeout' => 30
            ]);
            
            $result = json_decode($response->getBody(), true);
            
            $data['prediction'] = $result['prediction'];
            $data['input_data'] = json_encode([
                'curah_hujan' => $result['last_values']['curah_hujan'],
                'pemupukan' => $result['last_values']['pemupukan'],
                'hasil_produksi' => $result['last_values']['hasil_produksi']
            ]);
            
        } catch (\Exception $e) {
            throw new \Exception("Gagal melakukan prediksi: " . $e->getMessage());
        }
        
        return $data;
    }

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}