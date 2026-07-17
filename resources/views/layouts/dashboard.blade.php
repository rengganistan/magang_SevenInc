<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Stockify Dashboard</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script>
        if (
            localStorage.getItem('color-theme') === 'dark' ||
            (!('color-theme' in localStorage) &&
                window.matchMedia('(prefers-color-scheme: dark)').matches)
        ) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

</head>

<body class="bg-gray-900">

    <x-navbar-dashboard />

    <div class="flex pt-16 overflow-hidden bg-gray-900">

        <x-sidebar.admin-sidebar />

        <div id="main-content"
            class="relative min-h-screen w-full overflow-y-auto bg-gray-900 lg:ml-64">

            <main class="min-h-screen p-4 sm:p-6 lg:p-8 bg-gray-900">

                @yield('content')

            </main>

            <x-footer-dashboard />

        </div>

    </div>

    {{-- SweetAlert Success --}}
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                confirmButtonColor: '#2563eb',
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif

    {{-- SweetAlert Delete --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            document.querySelectorAll('.delete-form').forEach(form => {

                form.addEventListener('submit', function(e) {

                    e.preventDefault();

                    Swal.fire({
                        title: 'Hapus Data?',
                        text: 'Data yang dihapus tidak dapat dikembalikan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {

                        if(result.isConfirmed){
                            form.submit();
                        }

                    });

                });

            });

        });
    </script>

</body>

</html>
