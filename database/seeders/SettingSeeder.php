<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run()
    {
        Setting::create(['key' => 'check_in_time', 'value' => '09:00', 'type' => 'time']);
        Setting::create(['key' => 'check_out_time', 'value' => '17:00', 'type' => 'time']);
        Setting::create(['key' => 'late_threshold_minutes', 'value' => '15', 'type' => 'integer']);
    }
}