
 <nav id="navbar-main" class="navbar is-fixed-top">
    <div class="navbar-brand">
      <a class="navbar-item mobile-aside-button">
        <span class="icon"><i class="mdi mdi-forwardburger mdi-24px"></i></span>
      </a>
    </div>
    {{-- <div class="navbar-brand">
        <div class="font-bold text-blue-400 text-xl flex sm:hidden ">
            {{config('app.name')}}
          </div>
      </div> --}}
    <div class="navbar-brand is-right">
      <a class="navbar-item --jb-navbar-menu-toggle" data-target="navbar-menu">
        <span class="icon"><i class="mdi mdi-dots-vertical mdi-24px"></i></span>
      </a>
    </div>
    <div class="navbar-menu" id="navbar-menu">
      <div class="navbar-end">
        <div class="navbar-item dropdown has-divider has-user-avatar">
          <a class="navbar-link">
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <div class="flex-shrink-0 mr-3">
                    <img class="h-10 w-10 rounded-full object-cover" src="{{ Storage::url(Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" />
                </div>
            @endif
            {{-- <div class="h-7 w-7 bg-blue-400 uppercase rounded-full mr-2 text-center text-white font-bold text-xl">
              {{Str::limit(Auth::user()->name,1,'')}}
            </div> --}}
            <div class="is-user-name"><span>{{Auth::user()->name}}</span></div>
            <span class="icon"><i class="mdi mdi-chevron-down"></i></span>
          </a>
          <div class="navbar-dropdown">
            <x-jet-responsive-nav-link href="{{ route('profile.show') }}"
             :active="request()->routeIs('profile.show')">
             <span class="icon"><i class="mdi mdi-user"></i></span>
                {{ __('My Profile') }}
            </x-jet-responsive-nav-link>

            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}"
                 :active="request()->routeIs('api-tokens.index')">
                 <span class="icon"><i class="mdi mdi-application"></i></span>
                    {{ __('API Tokens') }}
                </x-jet-responsive-nav-link>
            @endif
            <hr class="navbar-divider">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-jet-responsive-nav-link href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                this.closest('form').submit();">
                <span class="icon"><i class="mdi mdi-logout"></i></span>
                    {{ __('Log Out') }}
                </x-jet-responsive-nav-link>
            </form>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <aside class="aside is-placed-left is-expanded">
    <div class="aside-tools">
      <div class="font-bold text-blue-400 text-3xl">
        {{config('app.name')}}
      </div>
    </div>
    <div class="menu is-menu-main">
      <ul class="menu-list">
        @if (Auth::user()->role == 'Admin')
        <li class="{{ request()->routeIs('dashboard')?'active':''}} ">
            <x-jet-nav-link href="{{ route('dashboard') }}">
                <span class="icon"><i class="mdi mdi-desktop-mac text-white"></i></span>
                <span class="menu-item-label text-white">{{ __('Dashboard') }}</span>
            </x-jet-nav-link>
        </li>
        <li class="--set-active-tables-html">
            <a href="{{route('admin.checkins')}}">
              <span class="icon"><i class="mdi mdi-arrow-bottom-right-bold-outline"></i></span>
              <span class="menu-item-label">Checkins</span>
            </a>
        </li>
        <li class="--set-active-tables-html">
            <a href="{{route('admin.checkouts')}}">
              <span class="icon"><i class="mdi mdi-arrow-top-right-bold-outline"></i></span>
              <span class="menu-item-label">Checkouts</span>
            </a>
        </li>
        <li class="--set-active-tables-html">
            <a href="{{route('admin.transfers')}}">
              <span class="icon"><i class="mdi mdi-bank-transfer"></i></span>
              <span class="menu-item-label">Transfer</span>
            </a>
        </li>
        <li class="--set-active-tables-html">
          <a href="{{route('admin.invoices')}}">
            <span class="icon"><i class="mdi mdi-account-cash"></i></span>
            <span class="menu-item-label">Invoices</span>
          </a>
        </li>
        <li class="--set-active-tables-html">
          <a href="{{route('admin.store')}}">
            <span class="icon"><i class="mdi mdi-store"></i></span>
            <span class="menu-item-label">Store</span>
          </a>
        </li>
        {{-- <li class="--set-active-tables-html">
            <a href="{{route('admin.items')}}">
              <span class="icon"><i class="mdi mdi-table"></i></span>
              <span class="menu-item-label">Items</span>
            </a>
        </li> --}}
        <li class="--set-active-tables-html">
            <a href="{{ route('admin.warehouses') }}">
              <span class="icon"><i class="mdi mdi-warehouse"></i></span>
              <span class="menu-item-label">Warehouses</span>
            </a>
        </li>
        <li class="--set-active-tables-html">
            <a href="{{ route('admin.managers') }}">
              <span class="icon"><i class="mdi mdi-account-box"></i></span>
              <span class="menu-item-label">Managers</span>
            </a>
        </li>
        <li class="--set-active-tables-html">
            <a href="{{route('admin.clients')}}">
              <span class="icon"><i class="mdi mdi-account-group"></i></span>
              <span class="menu-item-label">Clients</span>
            </a>
        </li>
        <li class="--set-active-tables-html">
            <a href="{{ route('admin.categories') }}">
              <span class="icon"><i class="mdi mdi-view-list"></i></span>
              <span class="menu-item-label">Categories</span>
            </a>
        </li>
        <li class="--set-active-tables-html">
            <a href="{{ route('admin.unities') }}">
              <span class="icon"><i class="mdi mdi-google-circles-communities"></i></span>
              <span class="menu-item-label">Unities</span>
            </a>
        </li>
        @elseif (Auth::user()->role == 'Manager')
        <li class="{{ request()->routeIs('manager.dashboard')?'active':''}} ">
          <x-jet-nav-link href="{{ route('manager.dashboard') }}">
              <span class="icon"><i class="mdi mdi-desktop-mac text-white"></i></span>
              <span class="menu-item-label text-white">{{ __('Dashboard') }}</span>
          </x-jet-nav-link>
        </li>
        <li class="{{ request()->routeIs('manager.requests')?'active':''}} ">
          <x-jet-nav-link href="{{ route('manager.requests') }}">
              <span class="icon"><i class="mdi mdi-allergy text-white"></i></span>
              <span class="menu-item-label text-white">{{ __('Requests') }}</span>
          </x-jet-nav-link>
        </li>
        <li class="{{ request()->routeIs('manager.store')?'active':''}} ">
          <x-jet-nav-link href="{{ route('manager.store') }}">
              <span class="icon"><i class="mdi mdi-store text-white"></i></span>
              <span class="menu-item-label text-white">{{ __('Store') }}</span>
          </x-jet-nav-link>
        </li>
        <li class="{{ request()->routeIs('manager.slots')?'active':''}} ">
          <x-jet-nav-link href="{{ route('manager.slots') }}">
              <span class="icon"><i class="mdi mdi-select-place text-white"></i></span>
              <span class="menu-item-label text-white">{{ __('Slots') }}</span>
          </x-jet-nav-link>
        </li>
        <li class="{{ request()->routeIs('manager.products')?'active':''}} ">
          <x-jet-nav-link href="{{ route('manager.products') }}">
              <span class="icon"><i class="mdi mdi-format-list-text text-white"></i></span>
              <span class="menu-item-label text-white">{{ __('Products') }}</span>
          </x-jet-nav-link>
        </li>
        <li class="{{ request()->routeIs('manager.checkins')?'active':''}} ">
          <x-jet-nav-link href="{{ route('manager.checkins') }}">
              <span class="icon"><i class="mdi mdi-arrow-bottom-right-bold-outline text-white"></i></span>
              <span class="menu-item-label text-white">{{ __('Checkins') }}</span>
          </x-jet-nav-link>
        </li>
        <li class="{{ request()->routeIs('manager.checkouts')?'active':''}} ">
          <x-jet-nav-link href="{{ route('manager.checkouts') }}">
              <span class="icon"><i class="mdi mdi-arrow-top-right-bold-outline text-white"></i></span>
              <span class="menu-item-label text-white">{{ __('Checkout') }}</span>
          </x-jet-nav-link>
        </li>
        <li class="{{ request()->routeIs('manager.transfers')?'active':''}} ">
          <x-jet-nav-link href="{{ route('manager.transfers') }}">
              <span class="icon"><i class="mdi mdi-bank-transfer-in text-white"></i></span>
              <span class="menu-item-label text-white">{{ __('Incoming Transfers') }}</span>
          </x-jet-nav-link>
        </li>
        <li class="{{ request()->routeIs('manager.outgoings')?'active':''}} ">
          <x-jet-nav-link href="{{ route('manager.outgoings') }}">
              <span class="icon"><i class="mdi mdi-bank-transfer-out text-white"></i></span>
              <span class="menu-item-label text-white">{{ __('Outgoing Transfers') }}</span>
          </x-jet-nav-link>
        </li>
        <li class="{{ request()->routeIs('manager.clients')?'active':''}} ">
          <x-jet-nav-link href="{{ route('manager.clients') }}">
              <span class="icon"><i class="mdi mdi-table text-white"></i></span>
              <span class="menu-item-label text-white">{{ __('Clients') }}</span>
          </x-jet-nav-link>
        </li>
        <li class="{{ request()->routeIs('manager.invoices')?'active':''}} ">
          <x-jet-nav-link href="{{ route('manager.invoices') }}">
              <span class="icon"><i class="mdi mdi-account-cash text-white"></i></span>
              <span class="menu-item-label text-white">{{ __('Invoices') }}</span>
          </x-jet-nav-link>
        </li>
        @endif

        @if (Auth::user()->role == 'Client')
        <li class="--set-active-tables-html {{ request()->routeIs('client.items')?'active':''}}">
          <a href="{{ route('client.items') }}">
            <span class="icon"><i class="mdi mdi-view-list"></i></span>
            <span class="menu-item-label">All Items</span>
          </a>
        </li>
        <li class="--set-active-tables-html {{ request()->routeIs('client.requests.new')?'active':''}}">
          <a href="{{ route('client.requests.new') }}">
            <span class="icon"><i class="mdi mdi-plus-thick"></i></span>
            <span class="menu-item-label">New Requests</span>
          </a>
        </li>
        <li class="--set-active-tables-html {{ request()->routeIs('client.checkins')?'active':''}}">
          <a href="{{ route('client.checkins') }}">
            <span class="icon"><i class="mdi mdi-arrow-bottom-right-bold-outline"></i></span>
            <span class="menu-item-label">CheckIns</span>
          </a>
        </li>
        <li class="--set-active-tables-html {{ request()->routeIs('client.checkouts')?'active':''}}">
          <a href="{{ route('client.checkouts') }}">
            <span class="icon"><i class="mdi mdi-arrow-top-right-bold-outline"></i></span>
            <span class="menu-item-label">Checkouts</span>
          </a>
        </li>
        <li class="--set-active-tables-html {{ request()->routeIs('client.transfer')?'active':''}}">
            <a href="{{ route('client.transfer') }}">
              <span class="icon"><i class="mdi mdi-bank-transfer"></i></span>
              <span class="menu-item-label">Transfers</span>
            </a>
        </li>
        <li class="--set-active-tables-html {{ request()->routeIs('client.invoices')?'active':''}}">
          <a href="{{ route('client.invoices') }}">
            <span class="icon"><i class="mdi mdi-bank-transfer"></i></span>
            <span class="menu-item-label">Invoices</span>
          </a>
      </li>
        @endif
      </ul>
    </div>
  </aside>
