<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::set('facebook', 'https://www.facebook.com');
        Setting::set('instagram', 'https://www.instagram.com');
        Setting::set('twitter', 'https://twitter.com');
        Setting::set('youtube', 'https://www.youtube.com');
        Setting::set('currency', 'USD');
        Setting::set('currency_sign', '$');
    }
}
