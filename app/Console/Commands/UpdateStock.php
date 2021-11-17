<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Services\YahooFinanceParser;
use App\Models\Stock;
use App\Models\StockType;

class UpdateStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update stock data';

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
     */
    public function handle()
    {
        try {
            Stock::truncate();
            foreach (StockType::all() as $type) {
                $stocks = YahooFinanceParser::getTable($type->name);
                $stocks = array_slice($stocks, 0, 30);
                foreach ($stocks as $stock) {
                    $stock += [
                        'stock_type_id' => $type->id
                    ];
                    Stock::create($stock);
                }
            }
        } catch (\Throwable $th) {
            Log::channel('commands')->error('[' . $this->signature . '] ' . $this->description . ' FAILS. ' . $th->getMessage());
        }
        return Command::SUCCESS;
    }
}
