@use('App\Support\Media')
@if(count($c['tabs']))
<!-- Who We Area Start -->
<div class="who__area services section-padding" @if($c['background_image']) style="background-image: url('{{ Media::url($c['background_image']) }}');" @endif>
    <div class="container">
        <div class="row al-center">
            <div class="col-xl-6 col-lg-5 lg-mb-25">
                <div class="who__area-left">
                    <div class="who__area-left-image dark_image">
                        @if($c['image_one'])<img src="{{ Media::url($c['image_one']) }}" alt="{{ $c['title'] }}">@endif
                        <img class="who__area-left-image-shape" src="{{ asset('img/shape/shape-12.png') }}" alt="shape">
                        @if($c['image_two'])
                        <div class="who__area-left-image-two">
                            <img src="{{ Media::url($c['image_two']) }}" alt="{{ $c['title'] }}">
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-7">
                <div class="who__area-right">
                    <div class="who__area-right-title">
                        @if($c['subtitle'])<span class="subtitle-three">{{ $c['subtitle'] }}</span>@endif
                        <h2>{!! nl2br(e($c['title'])) !!}</h2>
                    </div>
                    <div class="who__area-right-btn">
                        <ul class="nav nav-pills gap-4">
                            @foreach($c['tabs'] as $tab)
                            <li class="nav-item">
                                <button class="btn-two {{ $loop->first ? 'active' : '' }}" data-bs-toggle="pill" data-bs-target="#who-tab-{{ $loop->index }}" type="button">{{ $tab['title'] ?? '' }}</button>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="tab-content">
                        @foreach($c['tabs'] as $tab)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="who-tab-{{ $loop->index }}">
                            <div class="who__area-right-tab">
                                <p>{{ $tab['text'] ?? '' }}</p>
                                <div class="who__area-right-tab-list">
                                    @foreach(array_filter(array_map('trim', preg_split('/\R/', $tab['points'] ?? ''))) as $point)
                                    <span><i class="fa-sharp fa-solid fa-circle-check"></i>{{ $point }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Who We Area End -->
@endif
