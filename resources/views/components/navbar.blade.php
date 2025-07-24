<nav>
    <div class="burger">
        <i class="ri-menu-line large-icon" id="toggleSidebar"></i>
    </div>

    <div class="info">
        @if (Auth::user()?->role_id === 1)
            <a href="{{ route('admin.profile') }}" class="text-small link">{{ Auth::user()?->warga?->nama }}</a>
            <a href="{{ route('admin.profile') }}"><i class="ri-user-line large-icon"></i></a>
        @else
            <a href="{{ route('warga.profile') }}" class="text-small link">{{ Auth::user()?->warga?->nama }}</a>
            <a href="{{ route('warga.profile') }}"><i class="ri-user-line large-icon"></i></a>
        @endif
    </div>
</nav>
