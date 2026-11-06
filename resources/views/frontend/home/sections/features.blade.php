@use('App\Support\Media')
<!-- Features Area Start -->
<div class="features__one section-padding">
    <div class="container">
        <div class="row al-center features__one-bg" @if($c['background_image']) style="background-image: url('{{ Media::url($c['background_image']) }}');" @endif>
            <div class="col-lg-5 lg-mb-25">
                <div class="features__one-left">
                    <h4>{{ $c['title'] }}</h4>
                    @if($c['client_image'] || $c['client_text'])
                    <div class="features__one-left-client lg-jc-center dark_image">
                        @if($c['client_image'])
                        <img src="{{ Media::url($c['client_image']) }}" alt="client-image">
                        @endif
                        <h6>{{ $c['client_text'] }}</h6>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-7">
                <div class="features__one-right lg-jc-center">
                    @foreach($c['items'] as $item)
                    <div class="features__one-right-item">
                        <div class="features__one-right-item-icon">
                            <i class="{{ $item['icon'] ?? '' }}"></i>
                        </div>
                        <div class="features__one-right-item-content">
                            <h6>{{ $item['title'] ?? '' }}</h6>
                            <p>{{ $item['text'] ?? '' }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Features Area End -->
