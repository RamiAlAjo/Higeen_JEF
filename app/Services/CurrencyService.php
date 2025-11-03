<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CurrencyService
{
    protected $baseCurrency = 'JOD';
    protected $currencies = ['NIS', 'USD', 'EUR', 'EGP'];
    protected $apiUrl = 'https://v6.exchangerate-api.com/v6/{key}/latest/{base}';
    protected $apiKey;

    protected $symbols = [
        'JOD' => 'JD',
        'NIS' => '₪',
        'USD' => '$',
        'EUR' => '€',
        'EGP' => 'E£',
    ];

    public function __construct()
    {
        $this->apiKey = config('app.exchange_rate_api_key');
    }

    /**
     * Get exchange rates, cached for 24 hours.
     */
    public function getRates()
    {
        return Cache::remember('exchange_rates', 86400, function () {
            if (!$this->apiKey) {
                Log::warning('Exchange Rate API key not configured. Using fallback rates.');
                return $this->getFallbackRates();
            }

            $url = str_replace(
                ['{key}', '{base}'],
                [$this->apiKey, $this->baseCurrency],
                $this->apiUrl
            );

            try {
                $response = Http::get($url);

                if ($response->successful()) {
                    $data = $response->json();
                    if ($data['result'] === 'success') {
                        $rates = [$this->baseCurrency => 1];
                        foreach ($this->currencies as $currency) {
                            $rates[$currency] = $data['conversion_rates'][$currency] ?? null;
                        }
                        Log::info('Exchange rates fetched successfully from API.', ['rates' => $rates]);
                        return $rates;
                    }
                }

                Log::error('Failed to fetch exchange rates from API: ' . $response->body());
            } catch (\Exception $e) {
                Log::error('Exchange rate API error: ' . $e->getMessage());
            }

            return $this->getFallbackRates();
        });
    }

    /**
     * Fallback static rates.
     */
    protected function getFallbackRates()
    {
        return [
            'JOD' => 1,
            'NIS' => 5.30,
            'USD' => 1.41,
            'EUR' => 1.30,
            'EGP' => 68.50,
        ];
    }

    public function convert($amount, $from, $to)
    {
        $rates = $this->getRates();

        if (!isset($rates[$from]) || !isset($rates[$to])) {
            throw new \Exception("Invalid currency code");
        }

        $amountInBase = $amount / $rates[$from];
        return $amountInBase * $rates[$to];
    }

    public function format($amount, $currency)
    {
        if (!isset($this->symbols[$currency])) {
            throw new \Exception("Invalid currency code for formatting");
        }

        return $this->symbols[$currency] . ' ' . number_format($amount, 2, '.', ',');
    }

    public function getSymbol($currency)
    {
        return $this->symbols[$currency] ?? $currency;
    }
}
