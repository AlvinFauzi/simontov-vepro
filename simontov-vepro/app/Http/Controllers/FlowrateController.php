<?php

namespace App\Http\Controllers;

use App\Models\Flowrate;
use App\Http\Requests\StoreFlowrateRequest;
use App\Http\Requests\UpdateFlowrateRequest;
use App\Http\Resources\FlowrateResource;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FlowrateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->dataTable($request);
        }
        return view('flowrate-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFlowrateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFlowrateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Flowrate  $flowrate
     * @return \Illuminate\Http\Response
     */
    public function show(Flowrate $flowrate)
    {
        return response()->json([
            'status' => 200,
            'data' => $flowrate,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Flowrate  $flowrate
     * @return \Illuminate\Http\Response
     */
    public function edit(Flowrate $flowrate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFlowrateRequest  $request
     * @param  \App\Models\Flowrate  $flowrate
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFlowrateRequest $request, Flowrate $flowrate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Flowrate  $flowrate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Flowrate $flowrate)
    {
        $flowrate->delete();
        return response()->json([
            'status' => 200,
            'message' => __('messages.success.delete'),
        ], 200);
    }

    public function dataTable(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'mag_date_time',
            2 => 'flowrate',
            3 => 'totalizer_1',
            4 => 'totalizer_2',
            5 => 'totalizer_3',
            6 => 'analog_1',
            7 => 'analog_2',
            8 => 'status_battery',
            9 => 'alarm',
            10 => 'bin_alarm',
            11 => 'file_name',
        );

        $totalData = Flowrate::when($request->from_date, function ($q) use ($request) {
            return $q->whereBetween('mag_date', array($request->from_date, $request->to_date));
        })
            ->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $flowrates = Flowrate::when($request->from_date, function ($q) use ($request) {
                return $q->whereBetween('mag_date', array($request->from_date, $request->to_date));
            })->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $flowrates =  Flowrate::when($request->from_date, function ($q) use ($request) {
                return $q->whereBetween('mag_date', array($request->from_date, $request->to_date));
            })->where('mag_date_time', 'LIKE', "%{$search}%")
                ->orWhere('flowrate', 'LIKE', "%{$search}%")
                ->orWhere('totalizer_1', 'LIKE', "%{$search}%")
                ->orWhere('totalizer_2', 'LIKE', "%{$search}%")
                ->orWhere('totalizer_3', 'LIKE', "%{$search}%")
                ->orWhere('analog_1', 'LIKE', "%{$search}%")
                ->orWhere('analog_2', 'LIKE', "%{$search}%")
                ->orWhere('status_battery', 'LIKE', "%{$search}%")
                ->orWhere('alarm', 'LIKE', "%{$search}%")
                ->orWhere('bin_alarm', 'LIKE', "%{$search}%")
                ->orWhere('file_name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Flowrate::when($request->from_date, function ($q) use ($request) {
                return $q->whereBetween('mag_date', array($request->from_date, $request->to_date));
            })->where('mag_date_time', 'LIKE', "%{$search}%")
                ->orWhere('flowrate', 'LIKE', "%{$search}%")
                ->orWhere('totalizer_1', 'LIKE', "%{$search}%")
                ->orWhere('totalizer_2', 'LIKE', "%{$search}%")
                ->orWhere('totalizer_3', 'LIKE', "%{$search}%")
                ->orWhere('analog_1', 'LIKE', "%{$search}%")
                ->orWhere('analog_2', 'LIKE', "%{$search}%")
                ->orWhere('status_battery', 'LIKE', "%{$search}%")
                ->orWhere('alarm', 'LIKE', "%{$search}%")
                ->orWhere('bin_alarm', 'LIKE', "%{$search}%")
                ->orWhere('file_name', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($flowrates)) {
            foreach ($flowrates as $flowrate) {
                $nestedData['id'] = $flowrate->id;
                $nestedData['mag_date'] = $flowrate->mag_date->isoFormat('LLL');
                $nestedData['flowrate'] = $flowrate->flowrate . ' ' . $flowrate->unit_flowrate;
                $nestedData['totalizer_1'] = $flowrate->totalizer_1 . ' ' . $flowrate->unittotalizer;
                $nestedData['totalizer_2'] = $flowrate->totalizer_2 . ' ' . $flowrate->unittotalizer;
                $nestedData['totalizer_3'] = $flowrate->totalizer_3 . ' ' . $flowrate->unittotalizer;
                $nestedData['analog_1'] = $flowrate->analog_1;
                $nestedData['analog_2'] = $flowrate->analog_2;
                $nestedData['status_battery'] = $flowrate->status_battery;
                $nestedData['alarm'] = $flowrate->alarm;
                $nestedData['bin_alarm'] = $flowrate->bin_alarm;
                $nestedData['file_name'] = $flowrate->file_name;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public function datepickerLang()
    {
        $data = [
            'month' => [
                [trans('date.month.jan')],
                [trans('date.month.feb')],
                [trans('date.month.mar')],
                [trans('date.month.apr')],
                [trans('date.month.may')],
                [trans('date.month.jun')],
                [trans('date.month.jul')],
                [trans('date.month.aug')],
                [trans('date.month.sep')],
                [trans('date.month.oct')],
                [trans('date.month.nov')],
                [trans('date.month.dec')],
            ],
            'day' => [
                [trans('date.day.su')],
                [trans('date.day.mo')],
                [trans('date.day.tu')],
                [trans('date.day.we')],
                [trans('date.day.th')],
                [trans('date.day.fr')],
                [trans('date.day.sa')],
            ],
            'button' => [
                'cancel' => trans('date.button.cancel'),
                'apply' => trans('date.button.apply'),
            ]
        ];
        return response()->json([
            'status' => 200,
            'data' => $data,
        ], 200);
    }
}
