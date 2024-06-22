<x-app-layout>
<div class="container mx-auto p-8">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-6">Daftar Studio</h2>
        @if($studios->isEmpty())
            <p class="text-gray-700">Tidak ada studio yang tersedia.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($studios as $studio)
                    <div class="bg-gray-100 overflow-hidden shadow-md sm:rounded-lg">
                        <img src="{{ asset('storage/' . $studio->image_path) }}" alt="{{ $studio->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                        <h3 class="text-lg font-bold mb-2">{{ $studio->name }}</h3>
                        <p class="text-gray-700">{{ Str::limit($studio->description, 100) }}</p>
                        <a href="{{ route('studios.show', $studio->id) }}" class="mt-4 inline-block bg-yellow-500 text-black font-bold px-4 py-2 rounded">Lihat Studio</a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
</x-app-layout>
