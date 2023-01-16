<?php

namespace App\Http\Livewire\Admin;

use App\Models\Registration;
use App\Models\Ticket;
use App\Models\User;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class StatisticPage extends Component
{
    public $sold = 0;
    public $ticket;
    public $user_total;
    public $admin_total;

    public function mount()
    {
        $this->ticket = Ticket::whereActive(1)->orderBy('updated_at', 'desc')->first();
        if (!$this->ticket) {
            return $this->redirect(route('admin.ticket'));
        }
        $this->ticket = $this->ticket->toArray();
        $this->sold = Registration::whereTicketId($this->ticket['id'])->sum('quantity');
        $this->user_total = User::query()->where('is_admin', 0)->count();
        $this->admin_total = User::query()->where('is_admin', 1)->count();
    }

    private function generateBarChart()
    {
        $registrations = Registration::query()->selectRaw('offices.name, sum(quantity) as sold')
            ->join('offices', 'offices.id', 'registrations.office_id')
            ->groupBy('office_id')
            ->toBase()
            ->get();

        $chart = ['labels' => [], 'data' => [], 'colors' => []];
        foreach ($registrations as $i => $registration) {
//            $column = $column->addColumn($registration->name, $registration->sold, '#fc8181');
            $chart['labels'][] = $registration->name;
            $chart['data'][] = $registration->sold;
            $chart['colors'][] = "#" . $this->colors($i);
        }


        return $chart;
    }

    public function render()
    {
        return view('livewire.admin.statistic-page', [
            'columnChart' => $this->generateBarChart(),
            'available_percent' => $this->ticket ? ($this->ticket['quota'] - $this->sold) * 100 / $this->ticket['quota'] : 0,
            'sold_percent' => $this->ticket ? $this->sold * 100 / $this->ticket['quota'] : 0
        ]);
    }

    private function colors($i)
    {
        $colors = Cache::rememberForever("colors", function () {
            $colors = [];
            for ($i = 0; $i < 100; $i++) {
                $colors[] = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
            }
            return $colors;
        });

        return $colors[$i];
    }
}
