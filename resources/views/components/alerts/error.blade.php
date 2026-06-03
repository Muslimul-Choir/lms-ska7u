@if(session('error'))
<script>
document.addEventListener('DOMContentLoaded', () => {
    Swal.fire({
        icon: 'error',
        title: 'Gagal, terjadi kesalahan',
        text: @json(session('error')),
        confirmButtonColor: '#dc2626',
        confirmButtonText: 'OK',
        timer: 5000,
        timerProgressBar: true,
    });
});
</script>
@endif