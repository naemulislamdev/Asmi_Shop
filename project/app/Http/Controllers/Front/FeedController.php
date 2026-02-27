<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function facebookFeed()
    {
        $products = Product::where('status', 1)->where("stock", ">", 0)->get();

        $xml = new \SimpleXMLElement('<rss/>');
        $xml->addAttribute('version', '2.0');
        $xml->addAttribute('xmlns:g', 'http://base.google.com/ns/1.0');

        $channel = $xml->addChild('channel');
        $channel->addChild('title', 'Asmi Shop');
        $channel->addChild('link', 'https://asmishop.com');
        $channel->addChild('description', 'Asmi Shop Product Feed');

        foreach ($products as $product) {

            $item = $channel->addChild('item');

            // Required
            $item->addChild('g:id', $product->id, 'http://base.google.com/ns/1.0');
            $item->addChild('g:title', htmlspecialchars($product->name), 'http://base.google.com/ns/1.0');
            $item->addChild(
                'g:description',
                htmlspecialchars(strip_tags($product->details ?? $product->name)),
                'http://base.google.com/ns/1.0'
            );
            $item->addChild('g:link', url('/product/' . $product->slug), 'http://base.google.com/ns/1.0');

            // Image (photo / thumbnail fallback)
            if (!empty($product->photo)) {
                $item->addChild(
                    'g:image_link',
                    asset('assets/images/products/' . $product->photo),
                    'http://base.google.com/ns/1.0'
                );
            } elseif (!empty($product->thumbnail)) {
                $item->addChild(
                    'g:image_link',
                    asset('assets/images/products/' . $product->thumbnail),
                    'http://base.google.com/ns/1.0'
                );
            }

            // SKU
            if (!empty($product->sku)) {
                $item->addChild(
                    'g:sku',
                    htmlspecialchars($product->sku, ENT_XML1 | ENT_COMPAT, 'UTF-8'),
                    'http://base.google.com/ns/1.0'
                );
            }

            // Product type
            if (!empty($product->product_type)) {
                $item->addChild('g:product_type', $product->product_type, 'http://base.google.com/ns/1.0');
            }

            $priceValue = (float) $product->getRawOriginal('price');

            // Base price
            $item->addChild(
                'g:price',
                number_format($priceValue, 2, '.', '') . ' BDT',
                'http://base.google.com/ns/1.0'
            );

            // Sale price
            if ($product->discount > 0 && !empty($product->discount_type)) {

                if ($product->discount_type === 'percent') {
                    $salePrice = $priceValue - ($priceValue * $product->discount / 100);
                } else {
                    $salePrice = $priceValue - $product->discount;
                }

                if ($salePrice > 0) {
                    $item->addChild(
                        'g:sale_price',
                        number_format($salePrice, 2, '.', '') . ' BDT',
                        'http://base.google.com/ns/1.0'
                    );
                }
            }




            // Stock
            $stock = $product->stock ?? $product->stock ?? 0;
            $item->addChild(
                'g:availability',
                $stock > 0 ? 'in stock' : 'out of stock',
                'http://base.google.com/ns/1.0'
            );
            $item->addChild('g:quantity', $stock, 'http://base.google.com/ns/1.0');

            // Brand
            $item->addChild('g:brand', 'Asmi Shop', 'http://base.google.com/ns/1.0');

            // Condition
            $item->addChild('g:condition', 'new', 'http://base.google.com/ns/1.0');



            // Measure / Unit
            if (!empty($product->measure)) {
                $item->addChild('g:unit_pricing_measure', $product->measure, 'http://base.google.com/ns/1.0');
            }

            // Views / Type (optional custom labels)
            if (!empty($product->views)) {
                $item->addChild('g:custom_label_3', 'views:' . $product->views, 'http://base.google.com/ns/1.0');
            }

            if (!empty($product->type)) {
                $item->addChild('g:custom_label_4', $product->type, 'http://base.google.com/ns/1.0');
            }
        }

        return Response::make($xml->asXML(), 200)
            ->header('Content-Type', 'application/xml');
    }
}
