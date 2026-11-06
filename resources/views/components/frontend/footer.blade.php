<!-- Footer Area Start -->
<div class="footer__area" @if($site['footer_background']) style="background-image: url('{{ \App\Support\Media::url($site['footer_background']) }}');" @endif>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-5 lg-mb-25">
                <div class="footer__area-widget">
                    <div class="logo">
                        <a href="{{ route('home') }}"><img src="{{ \App\Support\Media::url($site['logo_light']) }}" alt="{{ $site['site_name'] }}"></a>
                    </div>
                    <div class="footer__area-widget-company">
                        @if($site['footer_address'])
                        <p><a href="{{ $site['address_link'] ?: '#' }}" target="_blank" rel="noopener">{{ $site['footer_address'] }}</a></p>
                        @endif
                        @if(count($socialLinks))
                        <div class="social__icon mt-60">
                            <ul>
                                @include('components.frontend.social-links')
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-7">
                <div class="row">
                    <div class="col-sm-6 col-12 sm-mt-25">
                        <div class="footer__area-widget">
                            @if($site['phone'] || $site['phone_secondary'])
                            <h6>Phone</h6>
                            <div class="footer__area-widget-info mb-35">
                                @foreach(array_filter([$site['phone'], $site['phone_secondary']]) as $phone)
                                <p><a href="{{ \App\Support\Link::tel($phone) }}">{{ $phone }}</a></p>
                                @endforeach
                            </div>
                            @endif
                            @if($site['support_email'])
                            <h6>Email</h6>
                            <div class="footer__area-widget-info">
                                <p><a href="mailto:{{ $site['support_email'] }}">{{ $site['support_email'] }}</a></p>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6 col-12 sm-mt-25">
                        <div class="footer__area-widget">
                            <h6>Resources</h6>
                            <div class="footer-widget-menu">
                                <ul>
                                    <li><a href="{{ route('about') }}">About Us</a></li>
                                    <li><a href="{{ route('blog.index') }}">Blog</a></li>
                                    <li><a href="{{ route('testimonials') }}">Testimonials</a></li>
                                    <li><a href="{{ route('faq') }}">FAQs</a></li>
                                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 lg-mt-25">
                <div class="footer__area-widget">
                    <h6>Subscribe</h6>
                    <div class="footer__area-widget-subscribe">
                        <form action="{{ route('newsletter.subscribe') }}" method="POST">
                            @csrf
                            <input type="email" name="email" placeholder="Email Address" required="required">
                            <button type="submit" aria-label="Subscribe"><i class="fas fa-paper-plane"></i></button>
                            <label><input type="checkbox" name="terms" value="1" required> I agree with the terms and conditions</label>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright__area lg-t-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <p>{{ str_replace(':year', date('Y'), $site['copyright']) }}</p>
                </div>
                <div class="col-lg-6">
                    <div class="copyright__area-menu t-right lg-t-center lg-mt-5">
                        <ul>
                            <li><a href="{{ route('privacy') }}">Privacy & Policy</a></li>
                            <li><a href="{{ route('terms') }}">Terms and Conditions</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer Area End -->
