<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExternalLogisticsService
{
    /**
     * Mengambil informasi cuaca terkini berdasarkan koordinat lokasi.
     * Menangani timeout, error HTTP, dan data kosong secara aman.
     */
    public function getWeatherByCoordinates(?float $latitude, ?float $longitude): array
    {
        if (is_null($latitude) || is_null($longitude)) {
            return [
                'available' => false,
                'message' => 'Coordinates are not available for this location.',
            ];
        }

        try {
            $baseUrl = config('services.open_meteo.url', 'https://api.open-meteo.com/v1/forecast');

            $response = Http::timeout(5)
                ->retry(2, 200)
                ->get($baseUrl, [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'current_weather' => true,
                ]);

            if ($response->failed()) {
                Log::warning('Weather API returned non-200 status', [
                    'status' => $response->status(),
                    'lat' => $latitude,
                    'lng' => $longitude,
                ]);

                return [
                    'available' => false,
                    'message' => 'External weather service is temporarily unavailable.',
                ];
            }

            $data = $response->json('current_weather');

            if (empty($data)) {
                return [
                    'available' => false,
                    'message' => 'No weather data returned for these coordinates.',
                ];
            }

            return [
                'available' => true,
                'temperature_c' => $data['temperature'] ?? null,
                'windspeed_kmh' => $data['windspeed'] ?? null,
                'weathercode' => $data['weathercode'] ?? null,
                'observed_at' => $data['time'] ?? null,
                'disclaimer' => 'Informational operational context only; not an automated delay prediction.',
            ];
        } catch (\Throwable $e) {
            Log::error('Weather API request failed', ['error' => $e->getMessage()]);

            return [
                'available' => false,
                'message' => 'Failed to connect to external weather service (timeout or network error).',
            ];
        }
    }

    /**
     * Geocoding: mencari koordinat (lat/lng) dari nama kota/pelabuhan.
     */
    public function geocodeAddress(string $query): ?array
    {
        if (trim($query) === '') {
            return null;
        }

        try {
            $response = Http::timeout(5)
                ->withHeaders([
                    'User-Agent' => config('app.name', 'CargoTrace') . '/1.0',
                ])
                ->get('https://nominatim.openstreetmap.org/search', [
                    'q' => $query,
                    'format' => 'json',
                    'limit' => 1,
                ]);

            if ($response->successful() && !empty($response->json())) {
                $first = $response->json()[0];
                return [
                    'latitude' => (float) $first['lat'],
                    'longitude' => (float) $first['lon'],
                    'display_name' => $first['display_name'] ?? $query,
                ];
            }
        } catch (\Throwable $e) {
            Log::warning('Geocoding API failed', ['query' => $query, 'error' => $e->getMessage()]);
        }

        return null;
    }
}