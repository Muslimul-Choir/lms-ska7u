@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', () => {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: @json(session('success')),
        confirmButtonColor: '#C8992A',
        confirmButtonText: 'Kembali',
        timer: 2500,
        timerProgressBar: true,
    });
});
</script>
@endif