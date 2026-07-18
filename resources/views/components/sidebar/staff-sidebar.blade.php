<x-sidebar-dashboard>

    <x-sidebar-menu-dashboard
        routeName="staff.dashboard"
        title="Dashboard"/>

    <li class="pt-4">
        <span class="px-3 text-xs font-bold uppercase text-gray-400">
            PRODUK
        </span>
    </li>

    <x-sidebar-menu-dashboard
        routeName="staff.products.index"
        title="Daftar Produk"/>

    <li class="pt-4">
        <span class="px-3 text-xs font-bold uppercase text-gray-400">
            TRANSAKSI
        </span>
    </li>

    <div class="ml-5">

        <x-sidebar-menu-dashboard
            routeName="staff.transactions.incoming"
            title="Barang Masuk"/>

        <x-sidebar-menu-dashboard
            routeName="staff.transactions.outgoing"
            title="Barang Keluar"/>

    </div>

</x-sidebar-dashboard>
