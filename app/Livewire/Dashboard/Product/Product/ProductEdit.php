<?php

namespace App\Livewire\Dashboard\Product\Product;

use App\Models\Product\Category\PCategory;
use App\Models\Product\Product\Product;
use App\Models\Product\Product\Productsize;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class ProductEdit extends Component
{
    use WithFileUploads;

    public $ar = ['title' => '', 'content' => ''];
    public $en = ['title' => '', 'content' => ''];
    public $price;
    public $cost_price;
    // Current image (string url for display)
    public $image;
    // New uploaded image (TemporaryUploadedFile)
    public $newImage;
    // Raw stored image value from DB (path or url)
    public $currentImage;
    public $locales = ['ar', 'en'];
    public $product;
    public $categories;
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
    public $can_replace;
    public $points;
    public $newSizes = [];

    public function mount($id){
        $this->product = Product::find($id);

        $this->ar['title'] = $this->product->translate('ar')->title;
        $this->ar['content'] = $this->product->translate('ar')->content;
        $this->en['title'] = $this->product->translate('en')->title;
        $this->en['content'] = $this->product->translate('en')->content;
        $this->price = $this->product->price;
        $this->cost_price = $this->product->cost_price;
        $this->currentImage = $this->product->getRawOriginal('image');
        $this->image = $this->product->image; // accessor for display
        $this->category_id = $this->product->category_id;
        $this->categories = PCategory::all();
        $this->sizes = $this->product->sizes;

        // Initialize newSizes with the correct structure
        $this->newSizes = [];
        foreach ($this->sizes as $size) {
            $this->newSizes[] = [
                'ar' => ['title' => $size->ar_title ?? ''],
                'en' => ['title' => $size->en_title ?? ''],
                'price' => $size->price ?? '',
                'cost_price' => $size->cost_price ?? ''
            ];
        }

        $this->custome_feilds = $this->product->custome_feilds;
        // Normalize legacy values: some places used `size` instead of `sizes`
        $storedPriceType = $this->product->price_type;
        if ($storedPriceType === 'size') {
            $storedPriceType = 'sizes';
        }
        // If price_type is missing in DB, infer it from existing sizes
        if (is_null($storedPriceType) || $storedPriceType === '') {
            $storedPriceType = ($this->product->sizes()->exists()) ? 'sizes' : 'static';
        }
        $this->price_type = $storedPriceType;
        $this->static_price = ($this->price_type == 'static') ? true : false;
        $this->can_replace = $this->product->can_replace;
        $this->points = $this->product->points;
    }

    public function onCategoryChange($value)
    {
        $this->category_id = $value;
    }

    #[Title('Edit Product')]
    public function render()
    {
        return view('livewire.dashboard.product.product.product-edit');
    }

    public function updatedNewSizes($value, $key)
    {
        // Ensure the array is properly indexed
        $this->newSizes = array_values($this->newSizes);
    }

    public function addSize()
    {
        $this->newSizes[] = [
            'ar' => ['title' => ''],
            'en' => ['title' => ''],
            'price' => '',
            'cost_price' => 0
        ];
    }

    public function removeSize($index)
    {
        unset($this->newSizes[$index]);
        $this->newSizes = array_values($this->newSizes);
    }

    public function createProduct()
    {
        // Normalize legacy value on submit as well
        if ($this->price_type === 'size') {
            $this->price_type = 'sizes';
        }

        $this->validate([
            'category_id'               => 'required|exists:p_categories,id',
            'newImage'                  => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'ar.title'                  => 'required|string|max:255',
            'en.title'                  => 'required|string|max:255',
            'ar.content'                => 'required|string',
            'en.content'                => 'required|string',
            'can_replace'               => 'required|boolean',
            'points'                    => 'required_if:can_replace,1|numeric',
            'price_type'                => 'required|in:static,sizes',
            'price'                     => 'required_if:price_type,static|nullable|numeric',
            'cost_price'                => 'required_if:price_type,static|nullable|numeric',
            'newSizes.*.ar.title'       => 'required_if:price_type,sizes|string|max:255',
            'newSizes.*.en.title'       => 'required_if:price_type,sizes|string|max:255',
            'newSizes.*.price'          => 'required_if:price_type,sizes|numeric',
            'newSizes.*.cost_price'     => 'required_if:price_type,sizes|numeric',
        ]);

        $imageToStore = $this->currentImage;
        if ($this->newImage) {
            // Store relative path; the accessor will convert to URL
            $imageToStore = $this->newImage->store('images/product', 'public');
        }

        // Set base product price and cost
        $basePrice = 0;
        $baseCost = 0;
        if ($this->price_type === 'static') {
            $basePrice = (float) ($this->price ?? 0);
            $baseCost = (float) ($this->cost_price ?? 0);
        } else {
            $prices = collect($this->newSizes)
                ->pluck('price')
                ->filter(fn ($p) => $p !== null && $p !== '')
                ->map(fn ($p) => (float) $p);
            $basePrice = $prices->min() ?? 0;

            // For cost in size-based, we can just use the first one or min, but we'll save per size anyway.
            // For the product table itself, let's use the min cost as well.
            $costs = collect($this->newSizes)
                ->pluck('cost_price')
                ->filter(fn ($p) => $p !== null && $p !== '')
                ->map(fn ($p) => (float) $p);
            $baseCost = $costs->min() ?? 0;
        }

        DB::transaction(function () use ($imageToStore, $basePrice) {
            $this->product->update([
                'category_id'    => $this->category_id,
                'price'          => $basePrice,
                'cost_price'     => $baseCost,
                'ar'             => ['title' => $this->ar['title'], 'content' => $this->ar['content']],
                'en'             => ['title' => $this->en['title'], 'content' => $this->en['content']],
                'image'          => $imageToStore,
                'can_replace'    => (bool) $this->can_replace,
                'points'         => (float) ($this->points ?? 0),
                'price_type'     => $this->price_type,
            ]);

            // Recreate sizes for size-based pricing
            $this->product->sizes()->delete();

            if ($this->price_type === 'sizes' && !empty($this->newSizes)) {
                foreach ($this->newSizes as $size) {
                    if (!empty($size['ar']['title']) && !empty($size['en']['title'])) {
                        Productsize::create([
                            'product_id' => $this->product->id,
                            'ar_title'   => $size['ar']['title'],
                            'en_title'   => $size['en']['title'],
                            'price'      => (float) ($size['price'] ?? 0),
                            'cost_price' => (float) ($size['cost_price'] ?? 0),
                        ]);
                    }
                }
            }
        });

        session()->flash('success', __('Product updated successfully'));

        $this->redirect('/dashboard/product', navigate: true);
    }

    public function onCanReplaceChange($value)
    {
        $this->can_replace =  $value;
    }


    public function onPriceTypeChange($value)
    {
        $this->static_price = $value == 'static';
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
            'newSizes.*.ar.title' => __('Size.ar.title'),
            'newSizes.*.en.title' => __('Size.en.title'),
            'newSizes.*.price' => __('Price'),
            'newSizes.*.cost_price' => __('Cost Price'),
        ];
    }
}
