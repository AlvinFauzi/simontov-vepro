<?php

namespace Database\Seeders;

use App\Models\StatusAlarm;
use Illuminate\Database\Seeder;

class StatusAlarmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StatusAlarm::insert([
            ['name' => 'Insulation Fault'],
            ['name' => 'Coil Current Fault'],
            ['name' => 'Amplifier Overload'],
            ['name' => 'Data Checksum Fault'],
            ['name' => 'Low Power'],
            ['name' => 'Flow Overload'],
            ['name' => 'Pulse A Overload'],
            ['name' => 'Pulse B Overload'],
            ['name' => 'Consumption Interval Over Limit'],
            ['name' => 'Leakage'],
            ['name' => 'Empty Pipe'],
            ['name' => 'Low Impedance'],
            ['name' => 'Flow Over Limit'],
        ]);
    }
}
