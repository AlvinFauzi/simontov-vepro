<?php

namespace App\Http\Controllers;

use App\Http\Resources\FlowrateChartResource;
use App\Models\Flowrate;
use App\Models\StatusAlarm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            'flowrates' => Flowrate::selectRaw('count(*) as total, file_name')
                ->groupBy('file_name')
                ->get(),
            'setFileName' => Flowrate::first()->file_name
        ];
        return view('home', $data);
    }

    public function theme($theme)
    {
        if ($theme === 'dark-mode') {
            Session::put('theme', 'light-mode');
        } else {
            Session::put('theme', 'dark-mode');
        }
        return [
            'data' => Session::get('theme')
        ];
    }

    public function filterFlowrate(Request $request)
    {
        $request->validate([
            'flowrate' => 'required|string|exists:flowrates,file_name',
            'fromDate' => 'required',
            'toDate' => 'required',
        ]);
        $start = Carbon::parse($request->fromDate);
        $end = Carbon::parse($request->toDate);

        $query = Flowrate::where([
            'file_name' => $request->flowrate,
        ])
            ->when($request->interval, function ($q) use ($request) {
                return $q->whereRaw('MOD(MINUTE(TIME(mag_date)),' . $request->interval . ') = 0 AND SECOND(TIME(mag_date)) = 0');
            })
            ->whereBetween('mag_date', array($start, $end))
            ->orderBy('mag_date', 'asc')
            ->get();

        $latest = Flowrate::where([
            'file_name' => $request->flowrate,
        ])
            ->when($request->interval, function ($q) use ($request) {
                return $q->whereRaw('MOD(MINUTE(TIME(mag_date)),' . $request->interval . ') = 0 AND SECOND(TIME(mag_date)) = 0');
            })
            ->whereBetween('mag_date', array($start, $end))
            ->orderBy('mag_date', 'asc')
            ->first();

        if ($latest) {
            $binData =  str_split($latest->getBin());
            $binDataFilter =  array_diff($binData, ['0']);
            $binItem = [];
            foreach ($binDataFilter as $item => $value) {
                $binItem[] = StatusAlarm::find($item + 1);
            }
            $data = [
                'binItem' => $latest ? $binItem : [],
                'data' => FlowrateChartResource::collection($query),
                'status_battery' => $latest->status_battery ?? null,
                'alarm' => $latest->alarm ?? null,
                'bin_alarm' => $latest->getBin() ?? null,
                'totalizer_1' => $latest ? $latest->totalizer_1  . ' ' . $latest->unittotalizer : null,
                'totalizer_2' => $latest ? $latest->totalizer_2  . ' ' . $latest->unittotalizer : null,
                'totalizer_3' => $latest ? $latest->totalizer_3  . ' ' . $latest->unittotalizer : null,
                'max_flowrate' => $query->max('flowrate') . ' ' . ($latest->unit_flowrate ?? '-'),
                'min_flowrate' => $query->min('flowrate') . ' ' . ($latest->unit_flowrate ?? '-'),
                'max_analog' => $query->max('analog_2'),
                'min_analog' => $query->min('analog_2'),
                'dateRange' => $start->isoFormat('LLLL') . ' - ' . $end->isoFormat('LLLL'),
            ];

            return response()->json([
                'status' => 200,
                'data' => $data,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => trans('lang.notDataFound'),
            ], 404);
        }
    }
}
