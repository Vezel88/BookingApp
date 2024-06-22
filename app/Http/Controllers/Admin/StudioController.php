<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Studio;
use App\Models\StudioTime;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class StudioController extends Controller
{

    public function index(Request $request)
    {
        $query = $request->input('search');
        if ($query) {
            $studios = Studio::where('name', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->with('studioTimes')
                ->get();
        } else {
            $studios = Studio::with('studioTimes')->get();
        }

        return view('admin.afterinputstudio', compact('studios'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'studio_image' => 'required|image',
            'studio_name' => 'required|string|max:255',
            'studio_description' => 'required|string',
            'studio_facilities' => 'required|string',
            'studio_time.date' => 'required|date',
            'studio_time.start_time.*' => 'required|date_format:H:i',
            'studio_time.end_time.*' => 'required|date_format:H:i',
            'studio_time.price.*' => 'required|numeric|min:0',
        ]);

        $imagePath = $request->file('studio_image')->store('studio_images', 'public');

        // Create Studio
        $studio = Studio::create([
            'image_path' => $imagePath,
            'name' => $request->studio_name,
            'description' => $request->studio_description,
            'facilities' => $request->studio_facilities,
        ]);

        // Prepare studio time data
        $studioTimeData = $validated['studio_time'];
        $studioTimes = [];
        foreach ($studioTimeData['start_time'] as $key => $startTime) {
            $studioTimes[] = [
                'studio_id' => $studio->id,
                'date' => $studioTimeData['date'],
                'start_time' => $startTime,
                'end_time' => $studioTimeData['end_time'][$key],
                'price' => $studioTimeData['price'][$key],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert studio times
        StudioTime::insert($studioTimes);

        return redirect()->back()->with('success', 'Studio added successfully');
    }

    public function edit($id)
    {
        $studio = Studio::findOrFail($id);
        return view('admin.editstudio', compact('studio'));
    }

    public function update(Request $request, $id)
    {

        $studio = Studio::findOrFail($id);

        $validated = $request->validate([
            'studio_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'studio_name' => 'nullable|string|max:255',
            'studio_description' => 'nullable|string',
            'studio_facilities' => 'nullable|string',
            'studio_time.date' => 'nullable|date',
            'studio_time.start_time.*' => 'nullable|date_format:H:i',
            'studio_time.end_time.*' => 'nullable|date_format:H:i',
            'studio_time.price.*' => 'nullable|numeric|min:0',
        ]);



        if ($request->hasFile('studio_image')) {
            // Hapus gambar lama jika ada
            if ($studio->image_path) {
                Storage::delete('public/' . $studio->image_path);
            }

            // Simpan gambar baru
            $imagePath = $request->file('studio_image')->store('studio_images', 'public');
            $studio->image_path = $imagePath;
        }

        // Update hanya field yang ada dalam request
        if ($request->filled('studio_name')) {
            $studio->name = $request->studio_name;
        }
        if ($request->filled('studio_description')) {
            $studio->description = $request->studio_description;
        }
        if ($request->filled('studio_facilities')) {
            $studio->facilities = $request->studio_facilities;
        }

        $studio->save();

        // Hanya proses studio_time jika ada dalam request
        if ($request->has('studio_time.start_time') && $request->has('studio_time.end_time') && $request->has('studio_time.price')) {
            $studio->studioTimes()->delete();

            foreach ($request->studio_time['start_time'] as $index => $start_time) {
                if (!empty($start_time) && !empty($request->studio_time['end_time'][$index]) && !empty($request->studio_time['price'][$index])) {
                    $studioTime = new StudioTime();
                    $studioTime->studio_id = $studio->id;
                    $studioTime->date = $request->studio_time['date'];
                    $studioTime->start_time = $start_time;
                    $studioTime->end_time = $request->studio_time['end_time'][$index];
                    $studioTime->price = $request->studio_time['price'][$index];
                    $studioTime->save();
                }
            }
        }
        return redirect()->back()->with('success', 'Studio updated successfully');
    }



    public function destroy($id)
    {
        $studio = Studio::findOrFail($id);
        $studio->delete();

        return redirect()->route('studios.afterinput')->with('success', 'Studio deleted successfully');
    }

    public function book(Request $request, $studioId)
    {
        $validated = $request->validate([
            'time_slots' => 'required|array',
            'time_slots.*' => 'exists:studio_times,id',
        ]);

        $timeSlots = StudioTime::whereIn('id', $validated['time_slots'])->get();

        // Logic for booking the selected time slots
        // e.g., create booking records, reduce availability, etc.

        return redirect()->route('daftarstudio')->with('success', 'Pemesanan berhasil dilakukan!');
    }
}
