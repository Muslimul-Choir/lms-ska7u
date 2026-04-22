<div id="createModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5);">
    <div class="bg-white w-96 mx-auto mt-24 p-5 rounded">

        <h2 class="text-xl font-bold mb-4">Tambah Jam Belajar</h2>

        <form action="{{ route('jambelajar.store') }}" method="POST">
            @csrf

            <label>Jam Mulai</label>
            <input type="time" name="jam_mulai" class="w-full border p-2 mb-2">

            <label>Jam Selesai</label>
            <input type="time" name="jam_selesai" class="w-full border p-2 mb-4">

            <button class="bg-green-600 text-white px-4 py-2 rounded w-full">
                Simpan
            </button>
        </form>

        <button onclick="document.getElementById('createModal').style.display='none'"
            class="mt-2 text-red-500">
            Tutup
        </button>
    </div>
</div>