<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices;
class HomeController extends Controller
{/*
    public function __construct()
    {
        $this->middleware('auth');
    }
*/
    public function index(){    
       /* $chartjs = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['المدفوعة جزئياً ','غير المدفوعة ', 'الفواتير المدفوعة'])
            ->datasets([
                [
                    'backgroundColor' => ['#FF6384', '#36A2EB'],
                    'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                    'data' => [69, 59]
                ]
            ])
        ->options([]);
*/
                return view('home'/*, compact('chartjs')*/);



    }
}
