<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class DefaultSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data=[
            [
                'name' => 'min_coin_withdraw_limit',
                'value' => 200
            ]
        ];

        Setting::insert($data);

    }
}
