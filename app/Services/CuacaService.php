<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CuacaService
{
    public function get(?string $kota = null): ?array
    {
        $kota = $kota ?: config('services.cuaca.default_city', 'Denpasar');
        $ttl  = (int) config('services.cuaca.ttl', 900);
        $tz   = config('services.cuaca.timezone', 'Asia/Makassar');
        $cc   = config('services.cuaca.country_code', 'ID');

        $cacheKey = 'cuaca:' . Str::slug($kota) . ':' . $tz;

        return Cache::remember($cacheKey, $ttl, function () use ($kota, $tz, $cc) {
            $geo = Http::timeout(10)->get('https://geocoding-api.open-meteo.com/v1/search', [
                'name'        => $kota,
                'count'       => 1,
                'language'    => 'id',
                'format'      => 'json',
                'countryCode' => $cc,
            ])->json();

            if (empty($geo['results'][0])) return null;

            $loc = $geo['results'][0];
            $lat = $loc['latitude'];
            $lon = $loc['longitude'];

            $data = Http::timeout(10)->get('https://api.open-meteo.com/v1/forecast', [
                'latitude'  => $lat,
                'longitude' => $lon,
                'timezone'  => $tz,
                'current'   => 'temperature_2m,relative_humidity_2m,apparent_temperature,weather_code,wind_speed_10m',
                'daily'     => 'temperature_2m_max,temperature_2m_min,precipitation_probability_max',
            ])->json();

            if (empty($data['current'])) return null;

            $code = $data['current']['weather_code'] ?? null;

            return [
                'kota'     => $loc['name'] ?? $kota,
                'provinsi' => $loc['admin1'] ?? null,
                'suhu'     => $data['current']['temperature_2m'] ?? null,
                'lembap'   => $data['current']['relative_humidity_2m'] ?? null,
                'terasa'   => $data['current']['apparent_temperature'] ?? null,
                'angin'    => $data['current']['wind_speed_10m'] ?? null,
                'status'   => $this->statusCuacaIndonesia($code),
                'max'      => $data['daily']['temperature_2m_max'][0] ?? null,
                'min'      => $data['daily']['temperature_2m_min'][0] ?? null,
                'hujan'    => $data['daily']['precipitation_probability_max'][0] ?? 0,
            ];
        });
    }

    private function statusCuacaIndonesia(?int $code): string
    {
        return match ($code) {
            0 => 'Cerah',
            1, 2, 3 => 'Berawan',
            45, 48 => 'Berkabut',
            51, 53, 55 => 'Gerimis',
            61, 63, 65 => 'Hujan',
            80, 81, 82 => 'Hujan Lebat',
            95 => 'Badai Petir',
            96, 99 => 'Badai Petir + Hujan Es',
            default => 'Tidak diketahui',
        };
    }
}
