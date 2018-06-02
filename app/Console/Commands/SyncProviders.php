<?php

namespace App\Console\Commands;

use EAguad\Model\Provider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncProviders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'providers:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync providers';

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
     * @return mixed
     */
    public function handle()
    {

        $skip = 0;
        do {
            $sapProviders = collect(DB::connection('sap')
                ->table("OCRD")
                ->select("CardCode", "CardName", "Address", "ZipCode", "CntctPrsn", "City", "Country")
                ->skip($skip)
                ->take(100)
                ->get())
                ->each(function ($sapProvider) {
                    Provider::firstOrCreate([
                        'cardcode' => $sapProvider->CardCode,
                    ],
                        [
                            'cardname' => $sapProvider->CardName,
                            'address' => $sapProvider->Address,
                            'zipcode' => $sapProvider->ZipCode,
                            'contact_person' => $sapProvider->CntctPrsn,
                            'city' => $sapProvider->City,
                            'country' => $sapProvider->Country
                        ]);
                });

            $skip += 10;
        } while ($sapProviders->count());
    }
}
