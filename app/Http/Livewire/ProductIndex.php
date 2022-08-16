<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductIndex extends Component
{
    use WithPagination;

    public $categories;
    public $searchQuery;
    public $searchCategory;

    protected $paginationTheme = 'bootstrap';

    //how to preserve the query string in the url
    protected $queryString = [
        'searchQuery' => ['except' => '']
    ];

    public function mount()
    {
        //categories are in mount because categories won't change throughout the cycle of the page
        //they are kinda if static properties,so you mount them once and then use them in your blade
        //they query would run everytime in every render
        //whilst products will be dynamic so that is why we need to use render for products
        $this->categories = Category::all();
        $this->searchQuery = '';//by default empty
        $this->searchCategory = '';
    }

    public function render()
    {
        $products = Product::with('categories')
            ->when($this->searchQuery != '', function($query) {
                $query->where('name', 'like', '%'.$this->searchQuery.'%');
            })
            ->when($this->searchCategory != '', function($query) {
                $query->whereHas('categories', function($query2) {
                    $query2->where('id', $this->searchCategory);
                });
            })
            ->paginate(10);

        return view('livewire.product-index', [
            'products' => $products
        ]);
    }

    public function deleteProduct($product_id)
    {
        Product::find($product_id)->delete();
    }
}
