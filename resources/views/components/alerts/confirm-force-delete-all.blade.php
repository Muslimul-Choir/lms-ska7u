<script>

function showConfirmForceDeleteAll(label = 'Data') {
    return Swal.fire({
        title: 'Hapus Permanen Semua?',
        html: `Hapus PERMANEN <strong>SEMUA ${label.toLowerCase()}</strong> di trash?<br><small style="color:#dc2626;">Tindakan ini TIDAK BISA dibatalkan!</small>`,
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, hapus semua permanen',
        cancelButtonText: 'Batal',
        allowOutsideClick: false,
        allowEscapeKey: false,
    });
}
</script>