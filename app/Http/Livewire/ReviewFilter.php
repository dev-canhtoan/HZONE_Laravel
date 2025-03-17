<?php

namespace App\Http\Livewire;

use App\Models\Rate;
use Livewire\Component;


class ReviewFilter extends Component
{
    public $productId;
    public $selectedStar = null;
    public function filterReviews($star)
    {
        $this->selectedStar = $star;
    }
    public function getAllReviews()
    {
        $this->selectedStar = null;
    }
    public function render()
    {
        $reviews = Rate::where('product_id', $this->productId)->get();
        $reviewFilters = Rate::with('user')->where('product_id', $this->productId);
        if ($this->selectedStar !== null) {
            $reviewFilters->whereIn('star', (array) $this->selectedStar);
        }
        $reviewFilters = $reviewFilters->get();
        return view('livewire.review-filter', compact('reviews', 'reviewFilters'));
    }
}