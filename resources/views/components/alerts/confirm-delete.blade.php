@push('scripts')
    <script>
        function showConfirmDelete(isSoftDelete = true) {
            return Swal.fire({
                title: 'Hapus data?',
                text: isSoftDelete ? 'Data akan dipindahkan ke tempat sampah' :
                    'Data akan dihapus permanen, anda yakin?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                allowOutsideClick: false,
                allowEscapeKey: false
            });
        }
    </script>
@endpush
