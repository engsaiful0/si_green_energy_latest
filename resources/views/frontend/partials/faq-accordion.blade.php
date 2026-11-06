{{-- Slaze FAQ accordion. $faqs = [['question' => ..., 'answer' => ...], ...], $id = unique element id. --}}
<div id="{{ $id }}">
    @foreach($faqs as $faq)
    <div class="faq__area-item">
        <h6 class="icon {{ $loop->first ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#{{ $id }}-{{ $loop->index }}"><span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}.</span>{{ $faq['question'] ?? '' }}</h6>
        <div id="{{ $id }}-{{ $loop->index }}" class="faq__area-item-body collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#{{ $id }}">
            <p>{!! nl2br(e($faq['answer'] ?? '')) !!}</p>
        </div>
    </div>
    @endforeach
</div>
