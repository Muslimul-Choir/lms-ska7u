@push('scripts')
    <script>
        function showConfirmUpdate() {
            return Swal.fire({
                title: 'Simpan perubahan?',
                text: 'Data akan diperbarui',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#C8992A',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, simpan',
                cancelButtonText: 'Batal',
                allowOutsideClick: false,
                allowEscapeKey: false
            });
        }
    </script>
@endpush
