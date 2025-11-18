<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pressure;
use Illuminate\Support\Facades\Http;

class FetchPressure extends Command
{
    protected $signature = 'pressure:fetch';
    protected $description = 'Fetch atmospheric pressure from API';

    public function handle()
    {
        $apiKey = '70421ced67cb03cab98c370788e70b73';
        $lat = '54.31';
        $lon = '18.32';
        $response = Http::get("https://api.openweathermap.org/data/3.0/onecall", [
            'lat'   => $lat,
            'lon'   => $lon,
            'appid' => $apiKey,
            'units' => 'metric',
        ]);
        if ($response->successful()) {
            $data = $response->json();

            // w One Call 3.0 ciśnienie jest w current.pressure
            $pressure = $data['current']['pressure'] ?? null;

            if ($pressure) {
                Pressure::create([
                    'pressure'    => $pressure,
                    'recorded_at' => now(),
                ]);
                $this->info("Pressure saved: {$pressure} hPa");
            } else {
                $this->error("Pressure not found in response");
            }
        } else {
            $this->error("API error: ".$response->status()." ".$response->body());
        }
    }
}
