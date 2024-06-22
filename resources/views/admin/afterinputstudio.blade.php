@component('admin.layouts.admin')
<div class="container mx-auto ml-auto p-4 ">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-6">Daftar Studio</h2>

        <!-- Search Form -->
        <form action="{{ route('studios.index') }}" method="GET" class="mb-6 flex items-center">
            <input type="text" name="search" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2" placeholder="Cari berdasarkan nama studio" value="{{ request()->input('search') }}">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Cari</button>
        </form>

        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <thead class="bg-gray-800 text-white sticky top-0 ">
                    <tr>
                        <th class="px-4 py-2">Gambar</th>
                        <th class="px-4 py-2">Nama Studio</th>
                        <th class="px-4 py-2">Deskripsi</th>
                        <th class="px-4 py-2">Fasilitas</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Rentang Waktu</th>
                        <th class="px-4 py-2">Harga</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($studios as $studio)
                        @foreach($studio->studioTimes as $timeSlot)
                            <tr>
                                <td class="border px-4 py-2"><img src="{{ asset('storage/' . $studio->image_path) }}" alt="Gambar Studio" class="h-16 w-16"></td>
                                <td class="border px-4 py-2">{{ $studio->name }}</td>
                                <td class="border px-4 py-2">{{ $studio->description }}</td>
                                <td class="border px-4 py-2">{{ $studio->facilities }}</td>
                                <td class="border px-4 py-2">{{ $timeSlot->date }}</td>
                                <td class="border px-4 py-2">{{ $timeSlot->start_time }} - {{ $timeSlot->end_time }}</td>
                                <td class="border px-4 py-2">{{ $timeSlot->price }}</td>
                                <td class="border  px-4 py-2 g-3">
                                    <div class="flex align-center gap-3">
                                        <form action="{{ route('studios.destroy', $studio->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus studio ini?');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Hapus</button>
                                        </form>
                                        <a href="{{ route('studios.edit', $studio->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="8" class="border px-4 py-2 text-center">Tidak ada studio yang ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endcomponent
