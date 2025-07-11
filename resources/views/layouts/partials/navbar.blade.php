<nav class="navbar navbar-expand-lg navbar-dark bg-danger d-flex justify-content-center" style="font-size: 12px;">
    <div class="container">
        <a class="navbar-brand" href="{{ route('add.property') }}">
            <img src="{{ asset('assets/logos/spms-nav-logo.png') }}" class="img-fluid" width="60" alt="logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @if(auth()->user()->role == 'admin')
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item p-1">
                        {{-- access history --}}
                        <a class="nav-link text-white font-weight-bold" href="{{ url('/share-list') }}">
                            <img src="{{ asset('assets/logos/wa-icon.svg') }}" width="20" height="20">
                            存取紀錄 (<span class="wa-pre-share">0</span>)
                        </a>
                    </li>
                    <li class="nav-item p-1">
                        {{-- release --}}
                        <a class="nav-link text-white font-weight-bold" href="{{ url('/share') }}">
                            <img src="{{ asset('assets/logos/wa-icon.svg') }}" width="20" height="20">
                            發佈 (<span class="wa-selected">0</span>)
                        </a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="{{ url('/add-property') }}">Add Property</a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="{{ url('/property-list') }}">Property List</a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="{{ url('/create-staff') }}">Create Agent</a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="{{ url('/users') }}">User List</a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="{{ url('/admin-views') }}">All Views</a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="{{ url('/admin-search') }}">Admin Search</a>
                    </li>
                    <li class="nav-item p-1">
                        {{-- reset password --}}
                        <a class="nav-link text-white font-weight-bold" href="{{ url('/password-reset') }}">重設密碼</a>
                    </li>
                    <li class="nav-item p-1">
                        {{-- terms of use --}}
                        <a class="nav-link text-white font-weight-bold" href="{{ url('/terms-conditions') }}">使用條款</a>
                    </li>
                    <li class="nav-item p-1">
                        {{-- Online form --}}
                        <a class="nav-link text-white font-weight-bold" href="{{ url('/hyperlinks') }}">網上表格</a>
                    </li>
                    <li class="nav-item p-1">
                        {{-- Commonly used words --}}
                        <a class="nav-link text-white font-weight-bold" href="{{ url('/useful_words') }}">常用字</a>
                    </li>
                    <li class="nav-item p-1">
                        {{-- Sign out --}}
                        <a class="nav-link text-white font-weight-bold" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            登出
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>            
                </ul>
            @else
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item p-1">
                        {{-- access history --}}
                        <a class="nav-link text-white font-weight-bold" href="{{ url('/share-list') }}">
                            <img src="{{ asset('assets/logos/wa-icon.svg') }}" width="20" height="20">
                            存取紀錄 (<span class="wa-pre-share">0</span>)
                        </a>
                    </li>
                    <li class="nav-item p-1">
                        {{-- release --}}
                        <a class="nav-link text-white font-weight-bold" href="{{ url('/share') }}">
                            <img src="{{ asset('assets/logos/wa-icon.svg') }}" width="20" height="20">
                            發佈 (<span class="wa-selected">0</span>)
                        </a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="#">新增物業</a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="#">增加瀏覽</a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="#">進階搜尋</a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="#">SPMS系統條用簡介</a>
                    </li>
                    <li class="nav-item p-1">
                        {{-- reset password --}}
                        <a class="nav-link text-white font-weight-bold" href="{{ url('/password-reset') }}">重設密碼</a>
                    </li>
                    <li class="nav-item p-1">
                        {{-- terms of use --}}
                        <a class="nav-link text-white font-weight-bold" href="{{ url('/terms-conditions') }}">使用條款</a>
                    </li>
                    <li class="nav-item p-1">
                        {{-- Online form --}}
                        <a class="nav-link text-white font-weight-bold" href="{{ url('/hyperlinks') }}">網上表格</a>
                    </li>
                    <li class="nav-item p-1">
                        {{-- Commonly used words --}}
                        <a class="nav-link text-white font-weight-bold" href="{{ url('/useful_words') }}">常用字</a>
                    </li>
                    <li class="nav-item p-1">
                        {{-- Sign out --}}
                        <a class="nav-link text-white font-weight-bold" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            登出
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            @endif
        </div>
    </div>
</nav>