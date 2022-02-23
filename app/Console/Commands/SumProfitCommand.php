<?php

namespace App\Console\Commands;

use App\Repositories\Bookkeeping\CostsRepository;
use App\Repositories\Bookkeeping\ProfitsRepository;
use App\Repositories\OrdersRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SumProfitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profit:sum';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $ordersRepository;
    private $costsRepository;
    private $profitsRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->ordersRepository = app(OrdersRepository::class);
        $this->costsRepository = app(CostsRepository::class);
        $this->profitsRepository = app(ProfitsRepository::class);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date_now = Carbon::now()->toDateString();

        $profit_now = $this->profitsRepository->getRowByDate($date_now);
        $profit_old = $this->profitsRepository->getAll();

        foreach ($profit_old as $item) {
            $created_at = $item->date->toDateString();
            $item->profit = $this->ordersRepository->sumDoneOrdersTotalPriceByDate($created_at);
            $item->cost = $this->costsRepository->sumCostsByDate($created_at);
            $item->marginality = $item->profit - $item->cost;
            $item->turnover = $item->profit + $item->cost;
            $item->update();
        }

        if ($profit_now) {
            $profit_now->profit = $this->ordersRepository->sumDoneOrdersTotalPriceByDate($date_now);
            $profit_now->cost = $this->costsRepository->sumCostsByDate($date_now);
            $profit_now->marginality = $profit_now->profit - $profit_now->cost;
            $profit_now->turnover = $profit_now->profit + $profit_now->cost;
            $profit_now->update();
        } else {
            $profit = $this->profitsRepository->createNewModel();
            $profit->date = $date_now;
            $profit->cost = $this->costsRepository->sumCostsByDate($date_now);
            $profit->profit = $this->ordersRepository->sumDoneOrdersTotalPriceByDate($date_now);
            $profit->marginality = $profit->profit - $profit->cost;
            $profit->turnover = $profit->profit + $profit->cost;
            $profit->save();;
        }
    }
}
