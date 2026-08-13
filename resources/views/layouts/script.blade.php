<script src="{{ asset('dashboard_assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('dashboard_assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('dashboard_assets/js/moment.min.js') }}"></script>

<script src="{{ asset('dashboard_assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('dashboard_assets/vendor/overlay-scroll/custom-scrollbar.js') }}"></script>

<script src="{{ asset('dashboard_assets/vendor/toastify/toastify.js') }}"></script>
<script src="{{ asset('dashboard_assets/vendor/toastify/custom.js') }}"></script>

<script src="{{ asset('dashboard_assets/vendor/apex/apexcharts.min.js') }}"></script>
<script src="{{ asset('dashboard_assets/vendor/apex/custom/dash1/visitors.js') }}"></script>
<script src="{{ asset('dashboard_assets/vendor/apex/custom/dash1/sales.js') }}"></script>
<script src="{{ asset('dashboard_assets/vendor/apex/custom/dash1/sparkline.js') }}"></script>
<script src="{{ asset('dashboard_assets/vendor/apex/custom/dash1/tasks.js') }}"></script>
<script src="{{ asset('dashboard_assets/vendor/apex/custom/dash1/income.js') }}"></script>

<script src="{{ asset('dashboard_assets/js/custom.js') }}"></script>
<script src="{{ asset('dashboard_assets/js/todays-date.js') }}"></script>

{{-- DataTables via CDN (Bootstrap 5 styling) --}}
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

{{-- Toast / alert global helper --}}
<script>
    // Helper untuk menampilkan notifikasi SweetAlert
    window.showAlert = function (icon, title) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: icon,
            title: title,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    };

    // Helper konfirmasi hapus
    window.confirmDelete = function (callback) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: 'Data yang dihapus tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) callback();
        });
    };

    // Ambil CSRF token dari meta tag
    window.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

    /**
     * Helper AJAX generik untuk submit form CRUD.
     * @param {HTMLFormElement} form - elemen form
     * @param {string} url - endpoint tujuan
     * @param {string} method - POST/PUT/DELETE
     * @param {function} onSuccess - callback(res) saat res.success
     * @param {function} onError - callback(res) saat gagal (opsional)
     */
    window.submitForm = function (form, url, method, onSuccess, onError) {
        // Pastikan field _method ada di form untuk spoofing PUT/PATCH/DELETE.
        // HTTP method fetch HARUS 'POST' karena PHP hanya mem-parsing body multipart
        // (FormData) untuk POST. Jika method asli PUT, field form akan kosong.
        var fd = new FormData(form);
        if (method && method.toUpperCase() !== 'POST') {
            fd.set('_method', method.toUpperCase());
        }

        fetch(url, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': window.csrfToken, 'Accept': 'application/json' },
            body: fd
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) onSuccess(res);
            else {
                showAlert('error', res.message || 'Terjadi kesalahan.');
                if (onError) onError(res);
            }
        })
        .catch(() => showAlert('error', 'Gagal memproses permintaan.'));
    };

    /**
     * Helper untuk hapus data via AJAX.
     */
    window.deleteRecord = function (url, onSuccess) {
        fetch(url, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': window.csrfToken, 'Accept': 'application/json' },
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) onSuccess(res);
            else showAlert('error', res.message || 'Gagal menghapus data.');
        })
        .catch(() => showAlert('error', 'Gagal menghapus data.'));
    };

    @if(session('success'))
    document.addEventListener('DOMContentLoaded', function () {
        showAlert('success', '{{ session('success') }}');
    });
    @endif
    @if(session('error'))
    document.addEventListener('DOMContentLoaded', function () {
        showAlert('error', '{{ session('error') }}');
    });
    @endif
</script>

{{-- Stack untuk script khusus tiap halaman --}}
@stack('scripts')
