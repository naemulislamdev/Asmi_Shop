<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;


class ProductExport implements FromCollection, WithHeadings
{
    protected $fromDate;
    protected $toDate;

    public function __construct($fromDate, $toDate)
    {
        $this->fromDate = $fromDate;
        $this->toDate   = $toDate;
    }

    public function collection()
    {
        $now = Carbon::now();
        $nextMonth = $now->copy()->addMonth();

        $query = Product::with(['category', 'subcategory', 'childcategory'])
            ->whereNotNull('exp_date');

        if ($this->fromDate && $this->toDate) {
            // ✅ Custom range দিলে — শুধু exp_date range দিয়ে খুঁজবে
            $from = Carbon::parse($this->fromDate)->startOfDay();
            $to   = Carbon::parse($this->toDate)->endOfDay();

            $query->whereBetween('exp_date', [$from, $to]);
        } else {
            // ✅ Date না দিলে — default: expired বা next 1 month
            $query->whereDate('exp_date', '<=', $nextMonth->toDateString());
        }

        return $query->get()->map(function ($product) {
            return [
                $product->name,
                $product->sku,
                optional($product->category)->name,
                optional($product->subcategory)->name,
                optional($product->childcategory)->name,
                $product->price,
                $product->stock,
                $product->created_at,
                $product->exp_date,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Product Name',
            'SKU',
            'Category',
            'Subcategory',
            'Child Category',
            'Price',
            'Stock',
            'MFG Date',
            'EXP Date',
        ];
    }
}
