{{-- Site social links as <li> items. --}}
@foreach($socialLinks as $social)
<li><a href="{{ $social['url'] }}" target="_blank" rel="noopener"><i class="{{ $social['icon'] }}"></i></a></li>
@endforeach
