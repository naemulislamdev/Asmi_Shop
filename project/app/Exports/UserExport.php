<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        $rows = [];

        $users = User::with('orders')->get();

        foreach ($users as $user) {
            if ($user->orders->isEmpty()) {
                $rows[] = [
                    $user->id,
                    $user->name,
                    $user->phone,
                    $user->email,
                    $user->address,
                    Carbon::parse($user->created_at)
                        ->setTimezone('Asia/Dhaka')
                        ->format('Y-m-d h:i:s a'),
                    '—',
                    '—',
                    '—',
                    'No Order',
                ];
            }


            foreach ($user->orders as $order) {
                $rows[] = [
                    // ===== Old User Data =====
                    $user->id,
                    $user->name,
                    $user->phone,
                    $user->email,
                    $user->address,
                    Carbon::parse($user->created_at)
                        ->setTimezone('Asia/Dhaka')
                        ->format('Y-m-d h:i:s a'),

                    // ===== New Order Data =====
                    sprintf("%'.08d", $order->id),
                    Carbon::parse($order->created_at)
                        ->setTimezone('Asia/Dhaka')
                        ->format('Y-m-d h:i:s a'),
                    \App\Helpers\PriceHelper::showOrderCurrencyPrice(
                        $order->pay_amount * $order->currency_value,
                        $order->currency_sign
                    ),
                    $order->status,
                ];
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            // User headings
            'User ID',
            'Name',
            'Phone',
            'Email',
            'Address',
            'Purchase Date',

            // Order headings
            'Order ID',
            'Order Date (Dhaka)',
            'Amount',
            'Order Status',
        ];
    }
}
