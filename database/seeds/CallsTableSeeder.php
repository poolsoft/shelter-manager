<?php

use Illuminate\Database\Seeder;

class CallsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Call::class, 10)->create()->each(function ($call) {
            $call->animals()->save(App\Animal::all()->random());
        });
    }
}
