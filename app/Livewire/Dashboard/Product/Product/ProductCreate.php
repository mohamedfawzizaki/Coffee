<?php

namespace App\Livewire\Dashboard\Product\Product;

use App\Models\Product\Category\PCategory;
use App\Models\Product\Product\Product;
use App\Models\Product\Product\Productcustom;
use App\Models\Product\Product\Productsize;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductCreate extends Component
{
    use WithFileUploads;

    public $ar = ['title' => '', 'content' => ''];
    public $en = ['title' => '', 'content' => ''];
    public $price;
    public $cost_price = 0;
    public $image;
    public $categories;
    public $locales = ['ar', 'en'];
    public $static_price = true;
    public $sizes = [];
    public $size_index = 0;
    public $custome_feilds = [];
    public $price_type;
    public $custome_feild_index = 0;
    public $custome_feild_image;
    public $custome_feild_ar_title;
    public $custome_feild_en_title;
    public $category_id;
    public $can_replace = 0;
    public $points = 0;

    public function mount()
    {
        $this->categories = PCategory::all();
    }

    public function onCategoryChange($value)
    {
        $this->category_id = $value;
    }

    #[Title('Create Default Product')]
    public function render()
    {
        return view('livewire.dashboard.product.product.product-create');
    }

    public function createProduct()
    {

        $this->validate([
            'category_id'               => 'required|exists:p_categories,id',
            'image'                     => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'price_type'                => 'required|in:static,sizes',
            'price'                     => 'required_if:price_type,static',
            'cost_price'                => 'required_if:price_type,static|numeric',
            'ar.title'                  => 'required|string|max:255',
            'en.title'                  => 'required|string|max:255',
            'ar.content'                => 'required|string',
            'en.content'                => 'required|string',
            'sizes'                     => 'required_if:price_type,sizes|array',
            'sizes.*.ar.title'          => 'required|string|max:255',
            'sizes.*.en.title'          => 'required|string|max:255',
            'sizes.*.price'             => 'required|numeric',
            'sizes.*.cost_price'        => 'required_if:price_type,sizes|numeric',
            'custome_feilds'            => 'sometimes|array',
            'custome_feilds.*.ar.title' => 'custome_feilds|string|max:255',
            'custome_feilds.*.en.title' => 'custome_feilds|string|max:255',
            'custome_feilds.*.image'    => 'custome_feilds|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'can_replace'               => 'required|boolean',
            'points'                    => 'required_if:can_replace,1|numeric',
        ]);

        // Check Price
        if($this->price_type == 'static'){

            $price = $this->price;
            $cost_price = $this->cost_price;

        }else{

            $price = $this->sizes[$this->size_index]['price'] ?? 0;
            $cost_price = $this->sizes[$this->size_index]['cost_price'] ?? 0;
        }



        // Handle Image Upload (store relative path; accessor converts to URL)
        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('images/product', 'public');
        }

        // Create Product

        $product = Product::create([
            'category_id'    => $this->category_id,
            'price'          => $price,
            'cost_price'     => $cost_price,
            'ar'             => ['title' => $this->ar['title'], 'content' => $this->ar['content']],
            'en'             => ['title' => $this->en['title'], 'content' => $this->en['content']],
            'image'          => $imagePath,
            'price_type'     => $this->price_type,
            'can_replace'    => $this->can_replace,
            'points'         => $this->points,
        ]);

        // Create Product Sizes

        if($this->price_type == 'sizes'){

        foreach($this->sizes as $size){

            Productsize::create([
                'product_id' => $product->id,
                'ar_title'   => $size['ar']['title'],
                'en_title'   => $size['en']['title'],
                'price'      => $size['price'],
                'cost_price' => $size['cost_price'] ?? 0,
            ]);
        }

        }

        // Create Product Custom Fields

        if($this->custome_feilds){

        foreach($this->custome_feilds as $custome_feild){

           Productcustom::create([
                'product_id' => $product->id,
                'ar_title'   => $custome_feild['ar']['title'],
                'en_title'   => $custome_feild['en']['title'],
                'image'      => $custome_feild['image'],
           ]);
          }
    }



        session()->flash('success', __('Product created successfully'));

        $this->redirect('/dashboard/product', navigate: true);
    }

    public function onPriceTypeChange($value)
    {
        $this->static_price = $value == 'static';
    }

    public function addSize()
    {
        $this->sizes[] = [
            'ar'    => ['title' => ''],
            'en'    => ['title' => ''],
            'price' => '',
            'cost_price' => 0,
        ];
    }

    public function removeSize($index)
    {
        unset($this->sizes[$index]);
        $this->sizes = array_values($this->sizes);
    }

    public function onCanReplaceChange($value)
    {
        $this->can_replace =  $value;
    }

    public function validationAttributes()
    {
        return [
            'ar.title' => __('ar.title'),
            'en.title' => __('en.title'),
            'ar.content' => __('ar.content'),
            'en.content' => __('en.content'),
            'price' => __('Price'),
            'cost_price' => __('Cost Price'),
            'sizes.*.ar.title' => __('Size.ar.title'),
            'sizes.*.en.title' => __('Size.en.title'),
            'sizes.*.price' => __('Price'),
            'sizes.*.cost_price' => __('Cost Price'),
        ];
    }
}
