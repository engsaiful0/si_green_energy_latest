{{--
    Slaze contact form; posts to the contact message store.
    $labels: name_placeholder, email_placeholder, phone_placeholder, subject_placeholder, message_placeholder, button_text
    $subject: optional fixed subject (hidden field), e.g. "Message for Lisa Thompson"
--}}
<div id="contact-form">
    @if(session('contact_success'))
        <div class="alert alert-success" role="status">{{ session('contact_success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contact.store') }}" method="POST" novalidate>
        @csrf
        {{-- Honeypot: hidden from people, filled by spam bots. --}}
        <div style="position: absolute; left: -10000px;" aria-hidden="true">
            <input type="text" name="website" tabindex="-1" autocomplete="off">
        </div>
        <div class="row">
            <div class="col-md-6 mb-30">
                <div class="contact__form-area-item">
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="{{ $labels['name_placeholder'] ?? 'Full Name' }}" required maxlength="255" aria-label="{{ $labels['name_placeholder'] ?? 'Full Name' }}">
                </div>
            </div>
            <div class="col-md-6 mb-30">
                <div class="contact__form-area-item">
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="{{ $labels['email_placeholder'] ?? 'Email Address' }}" required maxlength="255" aria-label="{{ $labels['email_placeholder'] ?? 'Email Address' }}">
                </div>
            </div>
            @if(!empty($subject))
            <input type="hidden" name="subject" value="{{ $subject }}">
            <div class="col-md-12 mb-30">
                <div class="contact__form-area-item">
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="{{ $labels['phone_placeholder'] ?? 'Phone Number' }}" maxlength="50" aria-label="{{ $labels['phone_placeholder'] ?? 'Phone Number' }}">
                </div>
            </div>
            @else
            <div class="col-md-6 mb-30">
                <div class="contact__form-area-item">
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="{{ $labels['phone_placeholder'] ?? 'Phone Number' }}" maxlength="50" aria-label="{{ $labels['phone_placeholder'] ?? 'Phone Number' }}">
                </div>
            </div>
            <div class="col-md-6 mb-30">
                <div class="contact__form-area-item">
                    <input type="text" name="subject" value="{{ old('subject') }}" placeholder="{{ $labels['subject_placeholder'] ?? 'Subject' }}" maxlength="255" aria-label="{{ $labels['subject_placeholder'] ?? 'Subject' }}">
                </div>
            </div>
            @endif
            <div class="col-md-12 mb-30">
                <div class="contact__form-area-item">
                    <textarea name="message" placeholder="{{ $labels['message_placeholder'] ?? 'Message' }}" required maxlength="5000" aria-label="{{ $labels['message_placeholder'] ?? 'Message' }}">{{ old('message') }}</textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="contact__form-area-item">
                    <button class="btn-one" type="submit">{{ $labels['button_text'] ?? 'Submit Message' }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
