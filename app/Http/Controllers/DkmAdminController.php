<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DkmAdminController extends Controller
{
    public function index()
    {
        $dkm = Auth::user();
        $animals = Animal::where('user_id', $dkm->id)->latest()->get();

        // Conversations preview (single query, no N+1)
        $conversations = ChatMessage::conversationsForDkm($dkm->id)
            ->map(fn ($conv) => array_merge($conv, [
                'last_time' => $conv['last_time'] ? $conv['last_time']->diffForHumans() : '',
            ]));

        return view('dkm.dashboard', compact('animals', 'conversations'));
    }

    public function storeAnimal(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:kambing,sapi,domba',
            'category' => 'required|in:aqiqah,qurban,harian',
            'price' => 'required|numeric|min:0',
            'weight_kg' => 'required|numeric|min:0',
            'gender' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Optional real upload; fall back to the type's stock image when none provided.
        $imagePath = '/images/' . $request->type . '.jpg';
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = '/storage/' . $request->file('image')->store('animals', 'public');
        }

        Animal::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'type' => $request->type,
            'category' => $request->category,
            'price' => $request->price,
            'weight_kg' => $request->weight_kg,
            'gender' => $request->gender,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => 'available',
        ]);

        return redirect()->back()->with('success', 'Hewan ternak berhasil ditambahkan ke katalog!');
    }

    public function updateStatus(Request $request, $id)
    {
        $animal = Animal::where('user_id', Auth::id())->findOrFail($id);
        $request->validate([
            'status' => 'required|in:available,reserved,sold',
        ]);

        $animal->status = $request->status;
        $animal->save();

        return redirect()->back()->with('success', 'Status hewan berhasil diperbarui.');
    }

    public function deleteAnimal($id)
    {
        $animal = Animal::where('user_id', Auth::id())->findOrFail($id);
        $animal->delete();

        return redirect()->back()->with('success', 'Hewan berhasil dihapus dari katalog.');
    }
}
