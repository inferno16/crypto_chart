<?php

namespace App\Console\Commands;

use App\Models\Currency;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class TickerFetch extends Command
{
    private static $variations = [
        ['BTC', 'USD'],
    ];
    private static $tickerUrl = 'https://api.bitfinex.com/v1/pubticker/';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ticker:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches data from the bitfinex API and saves it into the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws GuzzleException
     * @throws RuntimeException
     */
    public function handle()
    {
        // Verify is disabled for testing (I don't want to setup SSL locally)
        $client = new Client(['verify' => false]);
        // Fetch all to prevent multiple calls to the database
        $availableCurrencies = Currency::all();

        // Make assoc array iso_code => id
        $availableCurrencies = $availableCurrencies->pluck('id', 'iso_code');

        $pricesTable = DB::table('prices');
        foreach (self::$variations as $variation) {
            [$from, $to] = $variation;
            if (!$availableCurrencies->has($from) || !$availableCurrencies->has($to)) {
                throw new RuntimeException('Unsupported currencies: ' . json_encode($variation, JSON_THROW_ON_ERROR));
            }


            $responseBody = $client->get(self::$tickerUrl . $from . $to)
                ->getBody()
                ->getContents();

            $data = json_decode($responseBody, true, 512, JSON_THROW_ON_ERROR);
            // Convert from unix to mysql timestamp
            $data['timestamp'] = Carbon::createFromTimestamp($data['timestamp'])->format('Y-m-d H:i:s');
            // Change the ISO codes for ids from the database
            [$from, $to] = [$availableCurrencies[$from], $availableCurrencies[$to]];

            $pricesTable->insert(array_merge(compact('from', 'to'), $data));
        }

        return 0;
    }
}
