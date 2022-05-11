<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductsForm extends Component
{
    use WithFileUploads;

    public $categories;
    public Product $product;//bind the whole product as a public property of the component

    //this is dealt as a separate property
    public $productCategories;//helps to bind the multiple array of categories to the product
    public $photo;//separate property for photo

    protected $rules = [
        'product.name' => 'required|min:5',
        'product.description' => 'required|max:500',
        'product.color' => 'string',
        'product.in_stock' => 'boolean',
        'product.stock_date' => 'date',
        'productCategories' => 'required|array',//also separate rule
        'photo' => 'image',//also separate rule
    ];

    protected $messages = [
        'product.category_id.required' => 'Category is required'
    ];

    //if you want to customize the attribute name instead of the message
    protected $validationAttributes = [
        'product.category_id' => 'Category',
        'productCategories' => 'Categories'
    ];

    //you can use rules as a property or as a function
    //when you use rules a function, you can add complex rules
    public function rules(){
        return [

        ];
    }

    public function mount(Product $product)
    {
        $this->categories = Category::all();
        $this->product = $product ?? new Product();//if present we assign or
        $this->productCategories = $this->product->categories()->pluck('id');
    }

    public function render()
    {
        return view('livewire.products-form');
    }

    public function save()
    {
        $this->validate();

        $filename = $this->photo->store('products', 'public');//we store in the product's folder of public disk
        $this->product->photo = $filename;

        $this->product->save();
        //we save the product separately then with the belongs to many we sync
        $this->product->categories()->sync($this->productCategories);

        return redirect()->route('products.index');
    }

    public function updatedProductName()
    {
        $this->validateOnly('product.name');
    }
}
