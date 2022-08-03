<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FlowrateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'mag_date' => $this->faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
            'flowrate' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 100),
            'unit_flowrate' => 'm3/h',
            'totalizer_1' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 100),
            'totalizer_2' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 100),
            'totalizer_3' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 100),
            'unittotalizer' => 'm3',
            'analog_1' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 100),
            'analog_2' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 100),
            'status_battery' => $this->faker->numberBetween($min = 10, $max = 100),
            'alarm' => $this->faker->numberBetween($min = 10, $max = 150),
            'file_name' => 'FILE-' . $this->faker->numberBetween($min = 1, $max = 5),
        ];
    }
}
