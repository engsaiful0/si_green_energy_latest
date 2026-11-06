<!-- Search Box Start -->
<div class="header__area-menubar-right-search-box">
    <form action="{{ route('search') ?? '#' }}" method="GET">
        <input type="search" name="q" placeholder="Search Here....." value="{{ request('q') }}">
        <button type="submit"><i class="fal fa-search"></i></button>
    </form>
    <span class="header__area-menubar-right-search-box-icon"><i class="fal fa-times"></i></span>
</div>
<!-- Search Box End -->
