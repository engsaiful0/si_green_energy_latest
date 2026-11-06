{{-- Sidebar link list widget. $title, $links = [['label' => ..., 'url' => ..., 'active' => bool, 'count' => int|null], ...] --}}
@if(count($links))
<div class="all__sidebar-item">
    <h6>{{ $title }}</h6>
    <div class="all__sidebar-item-category">
        <ul>
            @foreach($links as $link)
            <li><a href="{{ $link['url'] }}" @if(!empty($link['active'])) style="color: var(--primary-color-1);" aria-current="page" @endif>{{ $link['label'] }}@if(isset($link['count'])) ({{ $link['count'] }})@endif<i class="fa-regular fa-arrow-right"></i></a></li>
            @endforeach
        </ul>
    </div>
</div>
@endif
