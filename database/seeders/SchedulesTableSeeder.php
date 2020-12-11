<?php

namespace Database\Seeders;

use App\Models\Discipline;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class SchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $disciplines = Discipline::all();
        Schedule::truncate();
        $count = 1;
        foreach ($disciplines as $discipline) {
            switch ($count) {
                case 1:
                    $scheduleData = $this->mondayData();
                    break;
                case 2:
                    $scheduleData = $this->tuesdayData();
                    break;
                case 3:
                    $scheduleData = $this->wednesdayData();
                    break;
                case 4:
                    $scheduleData = $this->thursdayData();
                    break;
                case 5:
                    $scheduleData = $this->fridayData();
                    break;
                default:
                    $scheduleData = $this->mondayData();
                    $count = 2;
                    break;
            }

            $discipline->addSchedule($scheduleData);
            $count++;
        }
    }

    private function mondayData()
    {
        return [
            'weekday' => 'Segunda-feira',
            'start_time' => '08:00',
            'end_time' => '11:30',
        ];
    }

    private function tuesdayData()
    {
        return [
            'weekday' => 'Terça-feira',
            'start_time' => '08:00',
            'end_time' => '11:30',
        ];
    }

    private function wednesdayData()
    {
        return [
            'weekday' => 'Quarta-feira',
            'start_time' => '08:20',
            'end_time' => '11:50',
        ];
    }

    private function thursdayData()
    {
        return [
            'weekday' => 'Quinta-feira',
            'start_time' => '08:15',
            'end_time' => '11:45',
        ];
    }

    private function fridayData()
    {
        return [
            'weekday' => 'Sexta-feira',
            'start_time' => '08:30',
            'end_time' => '11:30',
        ];
    }
}
