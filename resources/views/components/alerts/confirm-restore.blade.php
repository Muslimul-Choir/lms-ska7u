<script>

function showConfirmRestore(label = 'data') {
    return Swal.fire({
        title: 'Pulihkan Data?',
        text: `Data ${label} ini akan dikembalikan ke data utama.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#16a34a',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, pulihkan',
        cancelButtonText: 'Batal',
        allowOutsideClick: false,
        allowEscapeKey: false,
    });
}
</script>