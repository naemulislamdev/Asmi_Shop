<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function index()
    {
        return view('admin.sitemap.view');
    }
  public function download()
{
    $siteURL = "https://asmishop.com";
    $sitemap = Sitemap::create();

    $sitemap->add(
        Url::create($siteURL . '/')
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(1.0)
    );

    $sitemap->add(
        Url::create($siteURL . '/contact')
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setPriority(0.5)
    );

    Category::where('status', 1)
        ->select(['slug'])
        ->get()
        ->each(function ($category) use ($sitemap, $siteURL) {
            $sitemap->add(
                Url::create($siteURL . '/category/' . $category->slug)
                    ->setLastModificationDate(now())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.8)
            );
        });

    Product::where('status', 1)
        ->latest()
        ->select(['slug', 'updated_at', 'thumbnail', 'photo'])
        ->chunk(200, function ($products) use ($sitemap, $siteURL) {
            foreach ($products as $product) {
                $url = Url::create($siteURL . '/item/' . $product->slug)
                    ->setLastModificationDate($product->updated_at ?? now())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.9);

                if (!empty($product->thumbnail)) {
                    $url->addImage($siteURL . '/assets/images/thumbnails/' . $product->thumbnail);
                } elseif (!empty($product->photo)) {
                    $url->addImage($siteURL . '/assets/images/products/' . $product->photo);
                } else {
                    $url->addImage($siteURL . '/assets/images/noimage.png');
                }

                $sitemap->add($url);
            }
        });

    $path = public_path('sitemap.xml');
    $sitemap->writeToFile($path);

    Cache::forget('sitemap_xml');

    return response()->download($path);
}
}
