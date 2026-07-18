@php
    $authUser  = auth()->user();
    $userRole  = $authUser->role ?? 'staff';
    $initials  = strtoupper(substr($authUser->name ?? 'U', 0, 1));

    // Route-aware helpers
    $dashRoute    = match($userRole) {
        'admin'   => 'admin.dashboard',
        'manager' => 'manager.dashboard',
        default   => 'staff.dashboard',
    };
    $searchRoute  = match($userRole) {
        'admin'   => 'products.index',
        'manager' => 'manager.products.index',
        default   => 'staff.products.index',
    };
    $activityRoute = $userRole === 'admin' ? 'reports.activity' : $dashRoute;
    $productsRoute = match($userRole) {
        'admin'   => 'products.index',
        'manager' => 'manager.products.index',
        default   => 'staff.products.index',
    };
@endphp

<nav class="fixed z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-start">

          {{-- Mobile sidebar toggle --}}
          <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar"
            class="p-2 text-gray-600 rounded cursor-pointer lg:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
            <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
            <svg id="toggleSidebarMobileClose" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
          </button>

          {{-- Logo & Brand Name --}}
          <a href="{{ route($dashRoute) }}" class="flex items-center ml-2 md:mr-24">
            @if(!empty($navSetting->logo))
              <img src="{{ asset('storage/' . $navSetting->logo) }}" class="h-8 mr-3" alt="{{ $navSetting->app_name ?? 'Stokify' }}">
            @else
              <img src="{{ asset('static/images/logo.svg') }}" class="h-8 mr-3" alt="Stokify Logo" />
            @endif
            <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">
              {{ $navSetting->app_name ?? 'Stokify' }}
            </span>
          </a>

          {{-- Search Bar (Desktop) — role-aware --}}
          <form action="{{ route($searchRoute) }}" method="GET" class="hidden lg:block lg:pl-3.5">
            <label for="topbar-search" class="sr-only">Search</label>
            <div class="relative mt-1 lg:w-96">
              <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                </svg>
              </div>
              <input type="text" name="search" id="topbar-search"
                value="{{ request('search') }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                placeholder="Cari produk...">
            </div>
          </form>
        </div>

        <div class="flex items-center gap-1">

          {{-- Mobile search icon --}}
          <button id="toggleSidebarMobileSearch" type="button"
            class="p-2 text-gray-500 rounded-lg lg:hidden hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
            <span class="sr-only">Search</span>
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
            </svg>
          </button>

          {{-- Notifications --}}
          @php
            $totalNotif = ($navNotifications ?? collect())->count() + ($navLowStockProducts ?? collect())->count();
          @endphp
          <button type="button" data-dropdown-toggle="notification-dropdown"
            class="relative p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
            <span class="sr-only">Lihat notifikasi</span>
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
            </svg>
            @if($totalNotif > 0)
              <span class="absolute top-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs text-white font-bold leading-none">
                {{ $totalNotif > 9 ? '9+' : $totalNotif }}
              </span>
            @endif
          </button>

          {{-- Notification Dropdown --}}
          <div class="z-50 hidden max-w-sm w-80 my-4 overflow-hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:divide-gray-600 dark:bg-gray-700" id="notification-dropdown">
            <div class="block px-4 py-2 text-base font-semibold text-center text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
              Notifikasi
            </div>
            <div class="overflow-y-auto max-h-80">

              {{-- Stok Menipis --}}
              @forelse($navLowStockProducts ?? [] as $product)
              <a href="{{ route($productsRoute) }}" class="flex px-4 py-3 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600">
                <div class="flex-shrink-0">
                  <div class="flex items-center justify-center w-11 h-11 rounded-full bg-yellow-100 dark:bg-yellow-900">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                  </div>
                </div>
                <div class="w-full pl-3">
                  <div class="text-gray-500 font-normal text-sm mb-1 dark:text-gray-400">
                    Stok <span class="font-semibold text-gray-900 dark:text-white">{{ $product->nama }}</span>
                    menipis — sisa <span class="font-semibold text-red-600">{{ $product->stok }}</span>
                    (min: {{ $product->stok_minimum }})
                  </div>
                  <div class="text-xs font-medium text-yellow-600 dark:text-yellow-400">Peringatan Stok</div>
                </div>
              </a>
              @endforeach

              {{-- Activity Log --}}
              @forelse($navNotifications ?? [] as $notif)
              <a href="{{ route($activityRoute) }}" class="flex px-4 py-3 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600 last:border-b-0">
                <div class="flex-shrink-0">
                  <div class="flex items-center justify-center w-11 h-11 rounded-full bg-blue-100 dark:bg-blue-900">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                  </div>
                </div>
                <div class="w-full pl-3">
                  <div class="text-gray-500 font-normal text-sm mb-1 dark:text-gray-400">
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $notif->user->name ?? 'Sistem' }}</span>
                    {{ $notif->action }}
                    @php $act = strtolower($notif->action); @endphp
                    @if($notif->model_name && !str_contains($act, 'login') && !str_contains($act, 'logout'))
                      — <span class="text-gray-700 dark:text-gray-300">{{ $notif->model_name }}</span>
                    @endif
                  </div>
                  <div class="text-xs font-medium text-blue-600 dark:text-blue-400">
                    {{ $notif->created_at->diffForHumans() }}
                  </div>
                </div>
              </a>
              @empty
                @if(($navLowStockProducts ?? collect())->isEmpty())
                <div class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                  Tidak ada notifikasi terbaru
                </div>
                @endif
              @endforelse

            </div>
            @if($userRole === 'admin')
            <a href="{{ route('reports.activity') }}" class="block py-2 text-sm font-medium text-center text-gray-900 bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:text-white dark:hover:underline">
              <div class="inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                Lihat semua aktivitas
              </div>
            </a>
            @endif
          </div>

          {{-- Dark mode: locked to dark, toggle removed --}}

          {{-- Profile --}}
          <div class="flex items-center ml-1">
            <button type="button"
              class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
              id="user-menu-button-2" aria-expanded="false" data-dropdown-toggle="dropdown-2">
              <span class="sr-only">Buka menu pengguna</span>
              <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-sm">
                {{ $initials }}
              </div>
            </button>

            {{-- Profile Dropdown --}}
            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700 dark:divide-gray-600 min-w-48" id="dropdown-2">
              <div class="px-4 py-3" role="none">
                <div class="flex items-center gap-3 mb-1">
                  <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                    {{ $initials }}
                  </div>
                  <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $authUser->name ?? '-' }}</p>
                    <p class="text-xs text-gray-500 truncate dark:text-gray-400">{{ $authUser->email ?? '-' }}</p>
                    <span class="inline-block mt-0.5 px-2 py-0.5 text-xs font-medium rounded-full
                      @if($userRole === 'admin') bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300
                      @elseif($userRole === 'manager') bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300
                      @else bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300
                      @endif">
                      {{ ucfirst($userRole) }}
                    </span>
                  </div>
                </div>
              </div>
              <ul class="py-1" role="none">
                <li>
                  <a href="{{ route($dashRoute) }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
                    Dashboard
                  </a>
                </li>
                @if($userRole === 'admin')
                <li>
                  <a href="{{ route('settings.index') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
                    Pengaturan
                  </a>
                </li>
                @endif
                <li>
                  <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <a href="#" onclick="document.getElementById('logout-form').submit(); return false;"
                      class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:text-red-400 dark:hover:bg-gray-600">
                      Keluar
                    </a>
                  </form>
                </li>
              </ul>
            </div>
          </div>

        </div>
      </div>

      {{-- Mobile Search Bar --}}
      <div class="hidden mt-2 lg:hidden" id="mobile-search-bar">
        <form action="{{ route($searchRoute) }}" method="GET">
          <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
              <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
              </svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}"
              class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
              placeholder="Cari produk...">
          </div>
        </form>
      </div>

    </div>
</nav>

{{-- Mobile Search Toggle --}}
<script>
  const mobileSearchBtn = document.getElementById('toggleSidebarMobileSearch');
  const mobileSearchBar = document.getElementById('mobile-search-bar');
  if (mobileSearchBtn && mobileSearchBar) {
    mobileSearchBtn.addEventListener('click', function () {
      mobileSearchBar.classList.toggle('hidden');
      if (!mobileSearchBar.classList.contains('hidden')) {
        mobileSearchBar.querySelector('input').focus();
      }
    });
  }
</script>
