<x-sidebar-dashboard>

    <x-sidebar-menu-dashboard
        routeName="manager.dashboard"
        title="Dashboard"/>

    <li class="pt-4">
        <span class="px-3 text-xs font-bold uppercase text-gray-400">
            PRODUK
        </span>
    </li>

    <x-sidebar-menu-dashboard
        routeName="manager.products.index"
        title="Daftar Produk"/>

    <li class="pt-4">
        <span class="px-3 text-xs font-bold uppercase text-gray-400">
            TRANSAKSI
        </span>
    </li>

    <div class="ml-5">

        <x-sidebar-menu-dashboard
            routeName="manager.transactions.incoming"
            title="Barang Masuk"/>

        <x-sidebar-menu-dashboard
            routeName="manager.transactions.outgoing"
            title="Barang Keluar"/>

        <x-sidebar-menu-dashboard
            routeName="manager.stock-opname.index"
            title="Stock Opname"/>

    </div>

    <li class="pt-4">
        <span class="px-3 text-xs font-bold uppercase text-gray-400">
            SUPPLIER
        </span>
    </li>

    <x-sidebar-menu-dashboard
        routeName="manager.suppliers.index"
        title="Daftar Supplier"/>

    <li class="pt-4">
        <span class="px-3 text-xs font-bold uppercase text-gray-400">
            LAPORAN
        </span>
    </li>

    <div class="ml-5">

        <x-sidebar-menu-dashboard
            routeName="manager.reports.stock"
            title="Laporan Stok"/>

        <x-sidebar-menu-dashboard
            routeName="manager.reports.transaction"
            title="Laporan Transaksi"/>

    </div>

</x-sidebar-dashboard>
