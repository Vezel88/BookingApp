@component('admin.layouts.admin')
    <div class="container mx-auto p-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6">Tambah Studio Baru</h2>
            <form action="{{ route('studios.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="studioImage">
                        Gambar Studio
                    </label>
                    <input
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                        id="studioImage" type="file" name="studio_image" required onchange="previewImage(event)">
                    <img id="imagePreview" class="mt-4" style="max-height: 200px; display: none;" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="studioName">
                        Nama Studio
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="studioName" type="text" name="studio_name" placeholder="Nama Studio" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="studioDescription">
                        Deskripsi Studio
                    </label>
                    <textarea
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="studioDescription" name="studio_description" placeholder="Deskripsi Studio" required></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="studioFacilities">
                        Fasilitas Studio
                    </label>
                    <textarea
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="studioFacilities" name="studio_facilities" placeholder="Fasilitas Studio (pisahkan dengan koma)" required></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="studioDate">
                        Tanggal
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="studioDate" type="date" name="studio_time[date]" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="studioTimeSlots">
                        Rentang Waktu dan Harga per Jam
                    </label>
                    <div id="timeSlotContainer">
                        <div class="flex items-center mb-2">
                            <input
                                class="shadow appearance-none border rounded w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
                                type="time" name="studio_time[start_time][]" placeholder="Waktu Mulai" required>
                            <span class="mx-2">-</span>
                            <input
                                class="shadow appearance-none border rounded w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
                                type="time" name="studio_time[end_time][]" placeholder="Waktu Selesai" required>
                            <input
                                class="shadow appearance-none border rounded w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                type="number" name="studio_time[price][]" placeholder="Harga per Jam" required>
                            <button type="button" onclick="removeTimeSlot(this)"
                                class="ml-2 bg-red-500 text-white px-3 py-1 rounded">Hapus</button>
                        </div>
                    </div>
                    <button type="button" onclick="addTimeSlot()"
                        class="mt-4 bg-green-500 text-white px-4 py-2 rounded">Tambah Rentang Waktu</button>
                </div>

                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Tambah Studio
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const reader = new FileReader();

            reader.onload = function() {
                const preview = document.getElementById('imagePreview');
                preview.src = reader.result;
                preview.style.display = 'block';
            };

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }

        function addTimeSlot() {
            const container = document.getElementById('timeSlotContainer');
            const timeSlotHtml = `
            <div class="flex items-center mb-2">
                <input class="shadow appearance-none border rounded w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2" type="time" name="studio_time[start_time][]" placeholder="Waktu Mulai" required>
                <span class="mx-2">-</span>
                <input class="shadow appearance-none border rounded w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2" type="time" name="studio_time[end_time][]" placeholder="Waktu Selesai" required>
                <input class="shadow appearance-none border rounded w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" name="studio_time[price][]" placeholder="Harga per Jam" required>
                <button type="button" onclick="removeTimeSlot(this)" class="ml-2 bg-red-500 text-white px-3 py-1 rounded">Hapus</button>
            </div>`;
            container.insertAdjacentHTML('beforeend', timeSlotHtml);
        }

        function removeTimeSlot(button) {
            const timeSlot = button.parentElement;
            timeSlot.remove();
        }
    </script>
@endcomponent
