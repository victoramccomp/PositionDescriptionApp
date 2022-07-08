<?php

use Illuminate\Database\Seeder;
use App\ConfigPositionInterest;

class ConfigPositionInterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ConfigPositionInterest::create([
            'is_activated' => false,
            'terms_and_privacy' => 'Preencha seus termos de uso e política de privacidade'
        ]);
    }
}
