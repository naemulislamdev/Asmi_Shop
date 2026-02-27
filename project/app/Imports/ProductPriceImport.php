<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class ProductPriceImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // Get all SKUs from CSV
        $skus = $rows->pluck('sku')->filter()->toArray();

        // Get matching products from database
        $products = Product::whereIn('sku', $skus)
            ->get()
            ->keyBy('sku');

        $updatedCount = 0;

        foreach ($rows as $row) {

            if (!isset($row['sku']) || !isset($row['price'])) {
                continue;
            }

            if (isset($products[$row['sku']])) {

                $products[$row['sku']]->update([
                    'price' => $row['price'],
                    'stock' => $row['stock'] ?? $products[$row['sku']]->stock,
                ]);

                $updatedCount++;
            }
        }

        session()->flash('updated_count', $updatedCount);
    }
}
