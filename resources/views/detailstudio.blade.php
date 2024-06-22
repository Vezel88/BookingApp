<x-app-layout>
    <div class="container mx-auto p-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6">{{ $studio->name }}</h2>

            <div class="flex flex-col lg:flex-row mb-4">
                <div class="w-full lg:w-1/3 mb-4 lg:mb-0 lg:mr-4">
                    <img src="{{ asset('storage/' . $studio->image_path) }}" alt="{{ $studio->name }}"
                        class="w-full h-auto object-cover rounded-lg">
                </div>
                <div class="w-full lg:w-2/3">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold">Deskripsi:</h3>
                        <p class="text-gray-700">{{ $studio->description }}</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-lg font-bold">Fasilitas:</h3>
                        <p class="text-gray-700">{{ $studio->facilities }}</p>
                    </div>
                </div>
            </div>

            <!-- Tanggal Rentang Waktu -->
            <div class="flex justify-center mb-4">
                <div class="flex space-x-4">
                    @foreach ($dates as $date)
                        <div class="flex flex-col items-center cursor-pointer date-item {{ $date->isToday() ? 'text-red-600' : 'text-gray-500' }}"
                            data-date="{{ $date->format('Y-m-d') }}">
                            <div
                                class="w-12 h-12 flex items-center justify-center rounded-full {{ $date->isToday() ? 'bg-red-600 text-white' : 'text-gray-500' }} date-circle">
                                {{ $date->format('D') }}
                            </div>
                            <div class="text-sm {{ $date->isToday() ? 'text-red-600' : 'text-gray-500' }} date-text">
                                {{ $date->format('d M') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


            <div class="mb-4">
                <h3 class="text-lg font-bold">Rentang Waktu yang Tersedia:</h3>
                <form action="{{ route('studios.book', $studio->id) }}" method="POST">
                    @csrf
                    <div id="time-slots" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($studio->studioTimes as $timeSlot)
                            <label class="block bg-gray-100 shadow-sm rounded-lg p-4 time-slot"
                                data-date="{{ $timeSlot->date }}">
                                <input type="checkbox" name="time_slots[]" value="{{ $timeSlot->id }}" class="mr-2">
                                <div>
                                    <p class="text-gray-700"><strong>Tanggal:</strong> {{ $timeSlot->date }}</p>
                                    <p class="text-gray-700"><strong>Jam:</strong> {{ $timeSlot->start_time }} -
                                        {{ $timeSlot->end_time }}</p>
                                    <p class="text-gray-700"><strong>Harga:</strong> {{ $timeSlot->price }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    <button type="submit"
                        class="mt-4 bg-yellow-500 text-black font-bold px-4 py-2 rounded">Pesan</button>
                </form>
            </div>

            <a href="{{ route('daftarstudio') }}"
                class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">Kembali ke Daftar Studio</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateItems = document.querySelectorAll('.date-item');
            const timeSlots = document.querySelectorAll('.time-slot');

            dateItems.forEach(item => {
                item.addEventListener('click', () => {
                    // Remove 'active' class from all date items
                    dateItems.forEach(d => {
                        d.querySelector('.date-circle').classList.remove('bg-red-600',
                            'text-white');
                        d.querySelector('.date-circle').classList.add('text-gray-500');
                        d.querySelector('.date-text').classList.remove('text-red-600');
                        d.querySelector('.date-text').classList.add('text-gray-500');
                    });

                    // Add 'active' class to the clicked date item
                    item.querySelector('.date-circle').classList.add('bg-red-600', 'text-white');
                    item.querySelector('.date-circle').classList.remove('text-gray-500');
                    item.querySelector('.date-text').classList.add('text-red-600');
                    item.querySelector('.date-text').classList.remove('text-gray-500');

                    // Filter time slots by date
                    const selectedDate = item.getAttribute('data-date');
                    timeSlots.forEach(slot => {
                        if (slot.getAttribute('data-date') === selectedDate) {
                            slot.style.display = 'block';
                        } else {
                            slot.style.display = 'none';
                        }
                    });
                });
            });

            // Initial load: show today's slots
            const today = '{{ now()->format('Y-m-d') }}';
            timeSlots.forEach(slot => {
                if (slot.getAttribute('data-date') === today) {
                    slot.style.display = 'block';
                } else {
                    slot.style.display = 'none';
                }
            });
        });
    </script>
</x-app-layout>
