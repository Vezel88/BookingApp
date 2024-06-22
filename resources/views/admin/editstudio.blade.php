@component('admin.layouts.admin')
    <div class="container mx-auto p-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6">Edit Studio</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form action="{{ route('studios.update', $studio->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="studioImage">
                        Gambar Studio
                    </label>
                    <input
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                        id="studioImage" type="file" name="studio_image" onchange="previewImage(event)">
                    <img id="imagePreview" class="mt-4" src="{{ asset('storage/' . $studio->image_path) }}"
                        style="max-height: 200px;" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="studioName">
                        Nama Studio
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="studioName" type="text" name="studio_name" value="{{ $studio->name }}" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="studioDescription">
                        Deskripsi Studio
                    </label>
                    <textarea
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="studioDescription" name="studio_description" required>{{ $studio->description }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="studioFacilities">
                        Fasilitas Studio
                    </label>
                    <textarea
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="studioFacilities" name="studio_facilities" required>{{ $studio->facilities }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="studioDate">
                        Tanggal
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="studioDate" type="date" name="studio_time[date]"
                        value="{{ $studio->studioTimes->first()->date }}" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="studioTimeSlots">
                        Rentang Waktu dan Harga per Jam
                    </label>
                    <div id="timeSlotContainer">
                        @foreach ($studio->studioTimes as $timeSlot)
                            <div class="flex items-center mb-2">
                                <input
                                    class="shadow appearance-none border rounded w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
                                    type="time" name="studio_time[start_time][]" value="{{ $timeSlot->start_time }}"
                                    required>
                                <span class="mx-2">-</span>
                                <input
                                    class="shadow appearance-none border rounded w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
                                    type="time" name="studio_time[end_time][]" value="{{ $timeSlot->end_time }}"
                                    required>
                                <input
                                    class="shadow appearance-none border rounded w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    type="number" name="studio_time[price][]" value="{{ $timeSlot->price }}" required>
                                <button type="button" onclick="removeTimeSlot(this)"
                                    class="ml-2 bg-red-500 text-white px-3 py-1 rounded">Hapus</button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="addTimeSlot()"
                        class="mt-4 bg-green-500 text-white px-4 py-2 rounded">Tambah Rentang Waktu</button>
                </div>

                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Simpan Perubahan
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
                <input class="shadow appearance-none border rounded w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2" type="time" name="studio_time[start_time][]" required>
                <span class="mx-2">-</span>
                <input class="shadow appearance-none border rounded w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2" type="time" name="studio_time[end_time][]" required>
                <input class="shadow appearance-none border rounded w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" name="studio_time[price][]" required>
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
