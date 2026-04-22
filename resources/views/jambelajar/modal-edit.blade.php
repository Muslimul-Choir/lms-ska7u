<div id="editModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5);">
    <div class="bg-white w-96 mx-auto mt-24 p-5 rounded">

        <h2 class="text-xl font-bold mb-4">Edit Jam Belajar</h2>

        <form method="POST" id="editForm">
            @csrf
            @method('PUT')

            <input type="hidden" name="id" id="edit_id">

            <label>Jam Mulai</label>
            <input type="time" name="jam_mulai" id="edit_jam_mulai" class="w-full border p-2 mb-2">

            <label>Jam Selesai</label>
            <input type="time" name="jam_selesai" id="edit_jam_selesai" class="w-full border p-2 mb-4">

            <button class="bg-yellow-500 text-white px-4 py-2 rounded w-full">
                Update
            </button>
        </form>

        <button onclick="document.getElementById('editModal').style.display='none'"
            class="mt-2 text-red-500">
            Tutup
        </button>
    </div>
</div>

<script>
    function openEditModal(data){
        document.getElementById('editModal').style.display = 'block';

        document.getElementById('edit_id').value = data.id;
        document.getElementById('edit_jam_mulai').value = data.jam_mulai;
        document.getElementById('edit_jam_selesai').value = data.jam_selesai;

        document.getElementById('editForm').action = "/jambelajar/" + data.id;
    }
</script>