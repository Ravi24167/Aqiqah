<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalHotspot;
use App\Models\User;
use Illuminate\Http\Request;

class PublicCatalogController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category', 'all');
        $type = $request->query('type', 'all');

        $query = Animal::with('user')->where('status', 'available');

        if ($category !== 'all') {
            $query->where('category', $category);
        }

        if ($type !== 'all') {
            $query->where('type', $type);
        }

        $animals = $query->latest()->get();

        // Get DKM List for live chat selection
        $dkms = User::where('role', 'dkm_admin')->where('is_approved', true)->get();

        // Default hotspots
        $kambingHotspots = AnimalHotspot::where('animal_type', 'kambing')->get();
        $sapiHotspots = AnimalHotspot::where('animal_type', 'sapi')->get();
        $dombaHotspots = AnimalHotspot::where('animal_type', 'domba')->get();

        return view('welcome', compact(
            'animals',
            'dkms',
            'kambingHotspots',
            'sapiHotspots',
            'dombaHotspots',
            'category',
            'type'
        ));
    }

    // Anatomy Hub Page (/anatomi)
    public function anatomyHub()
    {
        return view('anatomy.index');
    }

    // Dedicated Detailed Anatomy Page (/anatomi/{type})
    public function showAnatomyPage($type)
    {
        if (!in_array($type, ['kambing', 'sapi', 'domba'])) {
            return redirect()->route('anatomy.hub');
        }

        $hotspots = AnimalHotspot::where('animal_type', $type)->get();
        $dkms = User::where('role', 'dkm_admin')->where('is_approved', true)->get();

        $titleMap = [
            'kambing' => 'Anatomi & Pemanfaatan Lengkap Kambing (Kulit, Mata, Buntut, Daging)',
            'sapi' => 'Anatomi & Pemanfaatan Lengkap Sapi (Kulit Bedug/Rambak, Mata, Buntut, Meat)',
            'domba' => 'Anatomi & Pemanfaatan Lengkap Domba (Wool, Tanduk, Mata, Buntut, Daging)',
        ];

        $pageTitle = $titleMap[$type] ?? 'Panduan Anatomi Hewan';

        return view('anatomy.show', compact('type', 'hotspots', 'dkms', 'pageTitle'));
    }

    // Figma Style Interactive Presentation Deck (/presentation)
    public function figmaPresentation()
    {
        return view('presentation');
    }

    public function getHotspots($type)
    {
        $hotspots = AnimalHotspot::where('animal_type', $type)->get();
        return response()->json([
            'success' => true,
            'animal_type' => $type,
            'hotspots' => $hotspots
        ]);
    }

    public function getAnimalDetail($id)
    {
        $animal = Animal::with('user')->findOrFail($id);
        return response()->json([
            'success' => true,
            'animal' => [
                'id' => $animal->id,
                'name' => $animal->name,
                'type' => ucfirst($animal->type),
                'category' => strtoupper($animal->category),
                'price_formatted' => $animal->formatted_price,
                'weight_kg' => $animal->weight_kg,
                'gender' => $animal->gender,
                'description' => $animal->description,
                'image' => $animal->image,
                'masjid_name' => $animal->user->masjid_name ?? 'DKM Masjid',
                'dkm_phone' => $animal->user->phone_number ?? '',
                'dkm_id' => $animal->user_id,
            ]
        ]);
    }
}
