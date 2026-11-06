{{-- Team member card (Slaze team item). Used by the homepage team section and the team page. --}}
<div class="team__one-item">
    <div class="team__one-item-image">
        <img src="{{ $member->photoUrl() }}" alt="{{ $member->full_name }}">
        <div class="team__one-item-image-content">
            @if(count($member->socialLinks()))
            <div class="team__one-item-image-icon">
                <span><i class="fas fa-share-alt"></i></span>
                <div class="team__one-item-image-social">
                    <ul>
                        @foreach($member->socialLinks() as $social)
                        <li><a href="{{ $social['url'] }}" target="_blank" rel="noopener"><i class="{{ $social['icon'] }}"></i></a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <h6><a href="{{ route('team.show', $member->slug) }}">{{ $member->full_name }}</a></h6>
            <span>{{ $member->position }}</span>
        </div>
    </div>
</div>
