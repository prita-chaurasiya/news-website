<?php

namespace Database\Seeders;

use App\Models\MarketTicker;
use Illuminate\Database\Seeder;

class MarketTickersSeeder extends Seeder
{
    public function run(): void
    {
        $tickers = [
            [
                'symbol' => 'SENSEX',
                'name' => 'BSE Sensex',
                'name_hi' => 'बीएसई सेंसेक्स',
                'type' => 'index',
                'price' => '81,540.20',
                'change' => '+680.40',
                'percent_change' => '+0.84%',
                'is_positive' => true,
                'sparkline' => [80800, 80950, 81100, 81050, 81300, 81420, 81540],
                'sort_order' => 1,
            ],
            [
                'symbol' => 'NIFTY 50',
                'name' => 'NSE Nifty 50',
                'name_hi' => 'एनएसई निफ्टी 50',
                'type' => 'index',
                'price' => '24,860.15',
                'change' => '+195.30',
                'percent_change' => '+0.79%',
                'is_positive' => true,
                'sparkline' => [24600, 24650, 24710, 24690, 24780, 24820, 24860],
                'sort_order' => 2,
            ],
            [
                'symbol' => 'GOLD 24K',
                'name' => 'Gold (10g)',
                'name_hi' => 'सोना (10 ग्राम)',
                'type' => 'commodity',
                'price' => '₹78,450',
                'change' => '-120.00',
                'percent_change' => '-0.15%',
                'is_positive' => false,
                'sparkline' => [78600, 78580, 78520, 78550, 78490, 78470, 78450],
                'sort_order' => 3,
            ],
            [
                'symbol' => 'USD/INR',
                'name' => 'US Dollar / Rupee',
                'name_hi' => 'डॉलर / रुपया',
                'type' => 'forex',
                'price' => '₹84.14',
                'change' => '+0.06',
                'percent_change' => '+0.07%',
                'is_positive' => true,
                'sparkline' => [84.05, 84.08, 84.07, 84.11, 84.12, 84.14, 84.14],
                'sort_order' => 4,
            ],
            [
                'symbol' => 'BITCOIN',
                'name' => 'Bitcoin',
                'name_hi' => 'बिटकॉइन',
                'type' => 'crypto',
                'price' => '$94,280',
                'change' => '+2,450.00',
                'percent_change' => '+2.67%',
                'is_positive' => true,
                'sparkline' => [91200, 91800, 92400, 92100, 93500, 93900, 94280],
                'sort_order' => 5,
            ],
            [
                'symbol' => 'CRUDE OIL',
                'name' => 'Brent Crude ($/bbl)',
                'name_hi' => 'कच्चा तेल',
                'type' => 'commodity',
                'price' => '$76.80',
                'change' => '-1.20',
                'percent_change' => '-1.54%',
                'is_positive' => false,
                'sparkline' => [78.2, 77.9, 77.5, 77.8, 77.1, 76.9, 76.8],
                'sort_order' => 6,
            ],
        ];

        foreach ($tickers as $ticker) {
            MarketTicker::updateOrCreate(['symbol' => $ticker['symbol']], $ticker);
        }
    }
}
