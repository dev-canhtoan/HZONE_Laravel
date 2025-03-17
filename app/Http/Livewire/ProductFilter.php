<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use App\Models\Spec;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;


class ProductFilter extends Component
{
    use WithPagination;
    public $selectedPriceRanges = [];
    public $filter = [];
    public $ram = [];
    public $selectedCategory = [];
    public $star = [];
    public $sort = [];
    public $discount = [];
    public $showAll = false;

    protected $queryString = ['filter', 'selectedPriceRanges', 'selectedCategory', 'ram', 'star', 'sort'];
    public function applyFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = Product::when($this->filter, function ($query1) {
                $query1->whereHas('spec', function ($query2) {
                    $query2
                        ->where(function ($query3) {
                        $query3->whereIn('brand', $this->filter);
                        })
                        ->orWhere(function ($query3) {
                            $query3->whereIn('storage', $this->filter);
                        });
                });
            })
            ->when($this->star, function ($query1) {
                $query1->whereHas('rates', function ($query){
                    $query->select(DB::raw('ROUND(AVG(star)) as average_rating'))
                        ->groupBy('product_id')
                        ->having('average_rating', '=', $this->star);
                });
            })
            ->when($this->discount, function ($query) {
                $query->whereIn('dis_id', $this->discount);
            })
            ->when($this->ram, function ($query) {
                $query->whereHas('spec', function ($query2) {
                    $query2->whereIn('ram', $this->ram);
                });
            })
            ->when($this->selectedCategory, function ($query) {
                $query->whereIn('cate_id', $this->selectedCategory);
            })
            
            
            ->when($this->sort, function ($query) {
                $query->when($this->sort == 'asc', function ($query2) {
                    $query2->select('product.*')
                    ->leftJoin('discount as d1', 'product.dis_id', '=', 'd1.id')
                    ->orderByRaw('IF(d1.percent IS NOT NULL, product.price * (1 - d1.percent / 100), product.price) ASC')
                    ->get();
                })
                    ->when($this->sort == 'desc', function ($query2) {
                    $query2->select('product.*')
                    ->leftJoin('discount as d1', 'product.dis_id', '=', 'd1.id')
                    ->orderByRaw('IF(d1.percent IS NOT NULL, product.price * (1 - d1.percent / 100), product.price) DESC')
                    ->get();
                });
            })
            
            ->when($this->selectedPriceRanges, function ($query) {
                $query->select('product.*')
                ->leftJoin('discount as d2', 'product.dis_id', '=', 'd2.id')
                ->where(function ($query2) {
                    foreach ($this->selectedPriceRanges as $priceRange) {
                        $priceValues = explode('-', $priceRange);
                        $minPrice = $priceValues[0];
                        $maxPrice = $priceValues[1];
                        $query2->orWhere(function($query3) use ($minPrice, $maxPrice) {
                            $query3->whereRaw('IF(d2.percent IS NOT NULL, product.price * (1 - d2.percent / 100), product.price) BETWEEN ? AND ?', [$minPrice, $maxPrice]);
                        });
                    }
                })
                ->get();
            })
            ->paginate(16);

        $categories =  Category::all();
        $brands = Spec::distinct()->pluck('brand')->filter()->sort()->toArray();
        $storages = Spec::distinct()->pluck('storage')->filter()->sort()->toArray();
        $rams = Spec::distinct()->pluck('ram')->filter()->sort()->toArray();
        $discounts = Discount::where('start_at', '<=', now())
        ->where('end_at', '>=', now())
        ->get();
        foreach ($products as $product) {
            $product->rates->avg_stars = $product->rates->avg('star');
        }
        return view('livewire.product-filter', compact('products', 'categories', 'brands', 'storages', 'rams', 'discounts'));
    }
}