<div class="overlay" id="overlay"></div>
<aside id="sidebar" class="aside">
    <div class="sidebar-header">

        <img src="{{ asset('logo/parahyangan original.png') }}" alt="logo">
        <i class="ri-close-line" id="closeSidebar"></i>
    </div>

    <p class="cp">Menu Utama</p>

    <div class="link">
        <div class="">
            <a href="{{ route('warga.dashboard') }}" class="text-regular {{ Request::is('warga/dashboard*') ? 'active' : '' }}"><i
                    class="ri-home-5-line regular-icon"></i>Dashboard</a>

            <a href="{{ route('warga.kasiuran') }}" class="text-regular {{ Request::is('warga/kasiuran*') ? 'active' : '' }}"><i
                    class="ri-money-dollar-circle-line regular-icon"></i>Iuran & Kas</a>

            <a href="{{ route('warga.berita') }}" class="text-regular {{ Request::is('warga/berita*') ? 'active' : '' }}"><i
                    class="ri-megaphone-line regular-icon"></i>Berita</a>

            <a href="{{ route('warga.surat') }}" class="text-regular {{ Request::is('warga/surat*') ? 'active' : '' }}"><i class="ri-mail-line regular-icon"></i>Surat</a>

            <a href="{{ route('warga.profile') }}" class="text-regular {{ Request::is('warga/profile*') ? 'active' : '' }}"><i class="ri-user-line regular-icon"></i>Data &
                Profil</a>

        </div>
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" name="" id="" value="" class="text-left text-large"><i
                    class="ri-logout-box-line"></i> logout</button>
        </form>
    </div>
</aside>
