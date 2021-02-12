<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cashier1 = User::find(1)->name;
        $cashier2 = User::find(2)->name;

        $transactions = [
            [
                'id' => 1,
                'product_id' => 1,
                'user_id' => 3,
                'cashier_name' => $cashier1,
                'quantity' => 2,
                'price' => 5000,
                'total' => 10000,
                'prefix_id' => 2,
                'invoice_number' => 'INV-2021-00001'
            ],
            [
                'id' => 2,
                'product_id' => 2,
                'user_id' => 3,
                'cashier_name' => $cashier1,
                'quantity' => 2,
                'price' => 2500,
                'total' => 5000,
                'prefix_id' => 2,
                'invoice_number' => 'INV-2021-00001'
            ],
            [
                'id' => 3,
                'product_id' => 3,
                'user_id' => 4,
                'cashier_name' => $cashier2,
                'quantity' => 1,
                'price' => 10000,
                'total' => 10000,
                'prefix_id' => 2,
                'invoice_number' => 'INV-2021-00001'
            ],
        ];

        foreach ($transactions as $transaction) {
            Transaction::create($transaction);
        }
    }
}

// GET FROM RANGE DATE CREATED_AT (NO CARBON)
// $transaction = Transaction::where(['user_id' => 3])->whereDate('created_at', '>', [date('Y-m-d', strtotime('2020-02-01')), date('Y-m-d', strtotime('2020-02-15'))])->get();

// GET FROM RANGE DATE CREATED_AT (WITH CARBON)
// $transaction = Transaction::where(['user_id' => 3])->whereDate('created_at', '>', [Carbon\Carbon::parse('2020-02-01'), Carbon\Carbon::parse('2020-02-15')])->get();
