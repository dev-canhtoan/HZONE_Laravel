<div class="rate-list">
    <button wire:click="getAllReviews" class="my-btn1" style="padding: 0px 5px">Tất cả đánh giá</button>
    <div class="star-rating">
        @for ($i = 5; $i > 0; $i--)
        <div class="star-rating-card" wire:click="filterReviews({{ $i }})">
            <span class="star">{{ $i }}<i class="fa-solid fa-star" style="color: #FFD700;"></i></span>    
            @php
                $totalReviews = count($reviews);
                $StarCount = $reviews->where('star', $i)->count(); 
                $Percentage = $totalReviews > 0 ? ($StarCount / $totalReviews) * 100 : 0;
            @endphp    
            <div class="bar">
                <div class="fill-bar" style="width: {{ $Percentage }}%"><span class="percentage">{{ round($Percentage) }}%</span></div>
            </div>
            {{ $StarCount }} đánh giá
        </div>
        @endfor
    </div>
    @foreach ($reviewFilters as $reviewFilter)
        <div class="rate-card">
            <h4>{{ $reviewFilter->user->username }}</h4>
            <p>{{ $reviewFilter->created_at }}</p>
            <div id="star-point">
                @for ($i = 0; $i < 5; $i++)
                    @if ($i< $reviewFilter->star)
                        <i class="fa-solid fa-star" style="color: #FFD700;"></i>
                    @else
                        <i class="fa-solid fa-star" style="color: #ddd;"></i>
                    @endif
                @endfor  
            </div>
            <p id="cmt">{{ $reviewFilter->comment }}</p>
        </div>
    @endforeach
</div>   
