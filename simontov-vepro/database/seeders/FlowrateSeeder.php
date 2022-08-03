<?php

namespace Database\Seeders;

use App\Models\Flowrate;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FlowrateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $list = [];
        for ($i = 1; $i <= 100; $i++) {
            $randpattern = '';
            while (strlen($randpattern) < $faker->numberBetween($min = 0, $max = 14))
                $randpattern .= rand(0, 1);

            $list[] = [
                'mag_date' => Carbon::now()->addHours(-1 * $i),
                'mag_date_time' => Carbon::now()->addHours(-1 * $i)->timestamp,
                'flowrate' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 100),
                'unit_flowrate' => 'm3/h',
                'totalizer_1' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 100),
                'totalizer_2' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 100),
                'totalizer_3' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 100),
                'unittotalizer' => 'm3',
                'analog_1' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50),
                'analog_2' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50),
                'status_battery' => $faker->numberBetween($min = 10, $max = 100),
                'alarm' => $faker->numberBetween($min = 10, $max = 150),
                'bin_alarm' => $randpattern,
                'file_name' => 'FILE-' . $faker->numberBetween($min = 1, $max = 5),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        $chunks = array_chunk($list, 2000);
        foreach ($chunks as $chunk) {
            Flowrate::insert($chunk);
        }
    }
}
