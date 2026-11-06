{{--
    Plain text with simple formatting: paragraphs separated by a blank line,
    and a short single line without final punctuation is shown as a sub-heading. Expects $text.
--}}
@foreach(array_filter(preg_split('/\R{2,}/', trim((string) $text))) as $paragraph)
    @if(!str_contains($paragraph, chr(10)) && mb_strlen($paragraph) <= 80 && !preg_match('/[.:!?]$/', $paragraph))
    <h4 class="mt-35 mb-15">{{ $paragraph }}</h4>
    @else
    <p>{!! nl2br(e($paragraph)) !!}</p>
    @endif
@endforeach
