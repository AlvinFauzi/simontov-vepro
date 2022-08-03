<?php

namespace App\Http\Controllers;

use App\Models\StatusAlarm;
use App\Http\Requests\StoreStatusAlarmRequest;
use App\Http\Requests\UpdateStatusAlarmRequest;
use Illuminate\Http\Request;

class StatusAlarmController extends Controller
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
        return view('status-alarm-list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStatusAlarmRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:status_alarms,name',
        ]);

        $alarm = new StatusAlarm();
        $alarm->name = $request->name;
        $alarm->save();

        return response()->json([
            'status' => 200,
            'message' => trans('messages.success.save')
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StatusAlarm  $statusAlarm
     * @return \Illuminate\Http\Response
     */
    public function show(StatusAlarm $alarm)
    {
        return response()->json([
            'status' => 200,
            'data' => $alarm,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStatusAlarmRequest  $request
     * @param  \App\Models\StatusAlarm  $statusAlarm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StatusAlarm $alarm)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:status_alarms,name,' . $alarm->id,
        ]);

        $alarm->name = $request->name;
        $alarm->update();

        return response()->json([
            'status' => 200,
            'message' => trans('messages.success.update')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StatusAlarm  $statusAlarm
     * @return \Illuminate\Http\Response
     */
    public function destroy(StatusAlarm $alarm)
    {
        $alarm->delete();
        return response()->json([
            'status' => 200,
            'message' => trans('messages.success.delete')
        ], 200);
    }

    public function dataTable(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
        );

        $totalData = StatusAlarm::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $statusAlarms = StatusAlarm::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $statusAlarms =  StatusAlarm::where('mag_date_time', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = StatusAlarm::where('mag_date_time', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($statusAlarms)) {
            foreach ($statusAlarms as $StatusAlarm) {
                $nestedData['id'] = $StatusAlarm->id;
                $nestedData['name'] = $StatusAlarm->name;
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
}
