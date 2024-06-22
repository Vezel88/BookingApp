<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Studio extends Model
{
    protected $fillable = [
        'image_path', // tambahkan ini
        'name',
        'description',
        'facilities',
    ];

    public function storeTime(Request $request, $studioId)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i:s',
            'waktu_selesai' => 'required|date_format:H:i:s|after:waktu_mulai',
            'harga' => 'required|numeric',
        ]);

        $studio = Studio::find($studioId);
        $studio->timeSlots()->create([
            'tanggal' => $request->tanggal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'harga' => $request->harga,
        ]);

        return redirect()->back()->with('success', 'Rentang waktu ditambahkan untuk studio.');
    }

    public function deleteTimeSlot($timeSlotId)
    {
        $studioTimeSlot = StudioTime::find($timeSlotId);
        $studioTimeSlot->delete();

        return redirect()->back()->with('success', 'Rentang waktu dihapus dari studio.');
    }

    public function studioTimes()
    {
        return $this->hasMany(StudioTime::class);
    }

}
