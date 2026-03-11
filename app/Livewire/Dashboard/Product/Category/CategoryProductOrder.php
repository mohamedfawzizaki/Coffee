<?php

namespace App\Livewire\Dashboard\Product\Category;

use App\Models\Product\Category\PCategory;
use App\Models\Product\Product\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

class CategoryProductOrder extends Component
{
    public $categories;

    public $categoryId;

    public $items;

    public bool $persist = false;

    // Track which category accordion items are open
    public $openCategoryId = null;

    public function mount()
    {
        $this->loadCategories();
        // When component mounts initially, ensure sortables will be initialized
        $this->dispatch('reinitializeSortable');
    }

    private function loadCategories()
    {
        $this->categories = PCategory::with(['products' => function($query) {
            $query->orderBy('sort');
        }])->orderBy('sort')->get();
    }

    public function updateProductOrder($categoryId, $items)
    {
        try {
            DB::beginTransaction();

            foreach ($items as $item) {
                Product::where('id', $item['id'])->update([
                    'sort' => $item['order']
                ]);
            }

            DB::commit();
            $this->loadCategories();

            // Keep the current category open
            $this->openCategoryId = $categoryId;

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => __('Product order updated successfully!')
            ]);

            // Trigger reinitialize of Sortable
            $this->dispatch('reinitializeSortable');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => __('Failed to update product order: ') . $e->getMessage()
            ]);
        }
    }

    public function updateCategoryOrder($items)
    {
        try {
            DB::beginTransaction();

            foreach ($items as $item) {
                PCategory::where('id', $item['id'])->update([
                    'sort' => $item['order']
                ]);
            }

            DB::commit();
            $this->loadCategories();

            // If we have an open category, keep it open
            // For categories, we want to preserve the openness state
            // We don't change it here as the user may be sorting the parent categories

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => __('Category order updated successfully!')
            ]);

            // Trigger reinitialize of Sortable
            $this->dispatch('reinitializeSortable');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => __('Failed to update category order: ') . $e->getMessage()
            ]);
        }
    }

    public function setOpenCategory($categoryId)
    {
        $this->openCategoryId = $categoryId;
    }

    #[Title('Products Sorting')]
    public function render()
    {
        // Every time component renders, ensure sortables can be reinitialized if needed
        $this->dispatch('reinitializeSortable');
        return view('livewire.dashboard.product.category.category-product-order');
    }
}
