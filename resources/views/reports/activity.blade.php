@extends('layouts.dashboard')

@section('content')

<div class="w-full px-4 py-6 sm:px-6 lg:px-8">

    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">
        <div>
            <p class="text-sm text-gray-400 mb-2">Dashboard / Laporan / Aktivitas Pengguna</p>
            <h1 class="text-3xl font-bold text-white">Laporan Aktivitas Pengguna</h1>
            <p class="mt-2 text-gray-400">Semua aktivitas yang dilakukan oleh pengguna sistem.</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow mb-8">
        <form action="{{ route('reports.activity') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">

                <div>
                    <label class="block mb-2 text-gray-300 text-sm">Pengguna</label>
                    <select name="user_id"
                        class="w-full rounded-xl bg-gray-700 border border-gray-600 text-white px-4 py-3">
                        <option value="">Semua Pengguna</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-gray-300 text-sm">Dari Tanggal</label>
                    <input type="date" name="start_date"
                        value="{{ request('start_date') }}"
                        class="w-full rounded-xl bg-gray-700 border border-gray-600 text-white px-4 py-3">
                </div>

                <div>
                    <label class="block mb-2 text-gray-300 text-sm">Sampai</label>
                    <input type="date" name="end_date"
                        value="{{ request('end_date') }}"
                        class="w-full rounded-xl bg-gray-700 border border-gray-600 text-white px-4 py-3">
                </div>

                <div class="flex items-end gap-2">
                    <button class="flex-1 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white">
                        Filter
                    </button>
                    <a href="{{ route('reports.activity') }}"
                        class="px-4 py-3 rounded-xl bg-gray-600 hover:bg-gray-500 text-white text-sm">
                        Reset
                    </a>
                </div>

            </div>
        </form>
    </div>

    {{-- Table --}}
    @php
        $showAll   = request()->boolean('show_all');
        $displayed = $showAll ? $activities : $activities->take(25);
        $remaining = $activities->count() - 25;
    @endphp

    <div class="overflow-hidden rounded-2xl border border-gray-700 bg-gray-800 shadow-xl">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-gray-300">No</th>
                        <th class="px-6 py-4 text-left text-gray-300">Pengguna</th>
                        <th class="px-6 py-4 text-left text-gray-300">Aktivitas</th>
                        <th class="px-6 py-4 text-left text-gray-300">Modul</th>
                        <th class="px-6 py-4 text-left text-gray-300">Detail</th>
                        <th class="px-6 py-4 text-left text-gray-300">Keterangan</th>
                        <th class="px-6 py-4 text-left text-gray-300">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">

                    @forelse($displayed as $activity)
                    <tr class="hover:bg-gray-700 transition">

                        <td class="px-6 py-4 text-white">{{ $loop->iteration }}</td>

                        <td class="px-6 py-4 text-white font-medium">
                            {{ $activity->user->name ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            @php
                                $color = 'bg-blue-600/20 text-blue-400';
                                $action = strtolower($activity->action);
                                if (str_contains($action, 'tambah') || str_contains($action, 'buat') || str_contains($action, 'masuk') || str_contains($action, 'import') || str_contains($action, 'login')) {
                                    $color = 'bg-green-600/20 text-green-400';
                                } elseif (str_contains($action, 'hapus')) {
                                    $color = 'bg-red-600/20 text-red-400';
                                } elseif (str_contains($action, 'edit') || str_contains($action, 'update') || str_contains($action, 'selesai')) {
                                    $color = 'bg-yellow-500/20 text-yellow-400';
                                } elseif (str_contains($action, 'keluar')) {
                                    $color = 'bg-orange-600/20 text-orange-400';
                                }
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">
                                {{ $activity->action }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-gray-400 text-sm">{{ $activity->model ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-300 text-sm">{{ $activity->model_name ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-400 text-sm">{{ $activity->keterangan ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-400 text-sm">
                            {{ $activity->created_at->format('d M Y, H:i') }}
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-16 text-center text-gray-400">
                            Belum ada aktivitas pengguna.
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Footer: lihat semua / sembunyikan --}}
        @if($activities->count() > 25)
        <div class="border-t border-gray-700 px-6 py-4 flex items-center justify-between">
            <p class="text-sm text-gray-400">
                Menampilkan <span class="text-white font-semibold">{{ $displayed->count() }}</span>
                dari <span class="text-white font-semibold">{{ $activities->count() }}</span> aktivitas
            </p>
            @if(!$showAll)
                <a href="{{ request()->fullUrlWithQuery(['show_all' => '1']) }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                    </svg>
                    Lihat Semua (+{{ $remaining }} lainnya)
                </a>
            @else
                <a href="{{ request()->fullUrlWithQuery(['show_all' => null]) }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gray-600 hover:bg-gray-500 text-white text-sm font-semibold transition">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"/>
                    </svg>
                    Sembunyikan
                </a>
            @endif
        </div>
        @endif

    </div>

</div>

@endsection
