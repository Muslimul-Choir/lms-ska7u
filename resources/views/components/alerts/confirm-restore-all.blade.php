<script>

function showConfirmRestoreAll(label = 'Data') {
    return Swal.fire({
        title: `Kembalikan Semua ${label}?`,
        text: `Kembalikan SEMUA ${label.toLowerCase()} yang ada di trash?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#16a34a',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, kembalikan semua',
        cancelButtonText: 'Batal',
        allowOutsideClick: false,
        allowEscapeKey: false,
    });
}
</script>