<?php

namespace Database\Seeders\Production;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class BookingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('bookings')->delete();

        DB::table('bookings')->insert([
            0 =>
            [
                'amount' => 192,
                'created_at' => '2020-09-24 17:39:15',
                'fee_id' => 1,
                'id' => 1,
                'is_private' => 1,
                'order_id' => 1,
                'participants' => 4,
                'rate_id' => 3,
                'slot_id' => 1,
                'tax_id' => 1,
                'total_fees' => 0,
                'total_taxes' => 0,
                'updated_at' => '2020-09-24 17:39:15',
            ],
            1 =>
            [
                'amount' => 98,
                'created_at' => '2020-09-24 17:39:15',
                'fee_id' => 1,
                'id' => 2,
                'is_private' => 1,
                'order_id' => 1,
                'participants' => 2,
                'rate_id' => 3,
                'slot_id' => 2,
                'tax_id' => 1,
                'total_fees' => 0,
                'total_taxes' => 0,
                'updated_at' => '2020-09-24 17:39:15',
            ],
        ]);
    }
}
