<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    protected $status;
    protected $fromDate;
    protected $toDate;

    public function __construct($status, $fromDate, $toDate)
    {
        $this->status   = $status;
        $this->fromDate = $fromDate;
        $this->toDate   = $toDate;
    }

    public function collection()
    {
        $query = Order::query();

        // Date filter
        if ($this->fromDate && $this->toDate) {
            $query->whereBetween('created_at', [$this->fromDate . ' 00:00:00', $this->toDate . ' 23:59:59']);
        }

        // Status filter
        if ($this->status !== 'all') {
            $query->where('status', $this->status);
        }
        return $query->get(['order_number', 'customer_name', 'customer_phone', 'customer_address', 'totalQty', 'pay_amount', 'created_at']);
    }

    public function headings(): array
    {
        return [
            'Order Number',
            'Customer Name',
            'Customer Phone',
            'Customer Address',
            'Total Quantity',
            'Total Cost',
            'Order Date',
        ];
    }
}
