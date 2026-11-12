<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Animal;
use App\Models\AnimalHotspot;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Super Admin Account
        $superAdmin = User::create([
            'name' => 'Super Admin Pusat',
            'email' => 'superadmin@aqiqah.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'phone_number' => '081234567890',
            'masjid_name' => 'Pusat Layanan Aqiqah & Qurban',
            'address' => 'Jakarta Selatan',
            'is_approved' => true,
        ]);

        // 2. Approved DKM Mosque Admins
        $dkm1 = User::create([
            'name' => 'Ustadz Ahmad (DKM Al-Falah)',
            'email' => 'dkm.alfalah@aqiqah.com',
            'password' => Hash::make('password'),
            'role' => 'dkm_admin',
            'masjid_name' => 'Masjid Al-Falah Indah',
            'phone_number' => '082198765432',
            'address' => 'Jl. Masjid No. 12, Kebayoran Baru, Jakarta',
            'is_approved' => true,
        ]);

        $dkm2 = User::create([
            'name' => 'Ustadz Ridwan (DKM An-Nur)',
            'email' => 'dkm.annur@aqiqah.com',
            'password' => Hash::make('password'),
            'role' => 'dkm_admin',
            'masjid_name' => 'Masjid Raya An-Nur',
            'phone_number' => '085712344321',
            'address' => 'Jl. Boulevard Raya No. 45, Bandung',
            'is_approved' => true,
        ]);

        // 3. Pending Approval DKM Mosque Admin
        User::create([
            'name' => 'Ustadz Hasan (DKM Al-Hidayah)',
            'email' => 'dkm.alhidayah@aqiqah.com',
            'password' => Hash::make('password'),
            'role' => 'dkm_admin',
            'masjid_name' => 'Masjid Al-Hidayah',
            'phone_number' => '081377889900',
            'address' => 'Jl. Pemuda No. 88, Surabaya',
            'is_approved' => false,
        ]);

        // 4. Seed Animals
        $animals = [
            [
                'user_id' => $dkm1->id,
                'name' => 'Kambing Aqiqah Super Grade A',
                'type' => 'kambing',
                'category' => 'aqiqah',
                'price' => 2800000,
                'weight_kg' => 32.5,
                'gender' => 'Jantan',
                'description' => 'Kambing jantan sehat, umur cukup syarat (syar\'i), bobot ideal untuk olahan gulai dan sate aqiqah 200 porsi.',
                'image' => '/images/kambing.jpg',
                'status' => 'available',
            ],
            [
                'user_id' => $dkm1->id,
                'name' => 'Kambing Peranakan Etawa (Harian/Sedekah)',
                'type' => 'kambing',
                'category' => 'harian',
                'price' => 3500000,
                'weight_kg' => 40.0,
                'gender' => 'Jantan',
                'description' => 'Cocok untuk hajat harian, syukuran nikahan, atau sedekah daging santri.',
                'image' => '/images/kambing.jpg',
                'status' => 'available',
            ],
            [
                'user_id' => $dkm2->id,
                'name' => 'Sapi Limosin Super Jumbo',
                'type' => 'sapi',
                'category' => 'qurban',
                'price' => 24500000,
                'weight_kg' => 420.0,
                'gender' => 'Jantan',
                'description' => 'Sapi Limosin gemuk & bertulang bagus, bebas penyakit, pakan teratur, pengiriman gratis.',
                'image' => '/images/sapi.jpg',
                'status' => 'available',
            ],
            [
                'user_id' => $dkm2->id,
                'name' => 'Sapi Bali Premium',
                'type' => 'sapi',
                'category' => 'harian',
                'price' => 18500000,
                'weight_kg' => 310.0,
                'gender' => 'Jantan',
                'description' => 'Daging serat halus, rasio daging tinggi dibanding lemak, siap potong kapan saja.',
                'image' => '/images/sapi.jpg',
                'status' => 'available',
            ],
            [
                'user_id' => $dkm1->id,
                'name' => 'Domba Garut Tanduk Mewah (Aqiqah/Kurban)',
                'type' => 'domba',
                'category' => 'aqiqah',
                'price' => 3200000,
                'weight_kg' => 35.0,
                'gender' => 'Jantan',
                'description' => 'Domba Garut asli, daging empuk aroma gurih khas, sangat diminati untuk aqiqah anak laki-laki & perempuan.',
                'image' => '/images/domba.jpg',
                'status' => 'available',
            ],
            [
                'user_id' => $dkm2->id,
                'name' => 'Domba Texel Gemuk Harian',
                'type' => 'domba',
                'category' => 'harian',
                'price' => 2600000,
                'weight_kg' => 30.0,
                'gender' => 'Betina',
                'description' => 'Siap untuk pemesanan harian, katering masjid, atau konsumsi keluarga.',
                'image' => '/images/domba.jpg',
                'status' => 'available',
            ],
        ];

        foreach ($animals as $animalData) {
            Animal::create($animalData);
        }

        // 5. 100% COMPLETE ANATOMICAL SEEDING (Kambing, Sapi, Domba)

        // ================= KAMBING =================
        AnimalHotspot::create([
            'animal_type' => 'kambing',
            'body_part' => 'Tanduk & Telinga',
            'part_category' => 'kerajinan',
            'pos_x' => 48,
            'pos_y' => 21,
            'benefits' => 'Tanduk keras bermotif unik, telinga kaya kikil rawan penyegar.',
            'recommended_recipes' => 'Oseng Kikil Telinga Cabai Hijau, Sop Kikil.',
            'utilization_details' => 'Kerajinan Gagang Pisau/Keris, Sisir Tanduk Kesehatan, Pipa Rokok Seni, Hiasan Dinding Ukir.',
            'icon' => 'fa-gem',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'kambing',
            'body_part' => 'Mata Kambing',
            'part_category' => 'kuliner',
            'pos_x' => 44,
            'pos_y' => 33,
            'benefits' => 'Tinggi kolagen murni, vitamin A, dan fosfor penyehat jaringan mata.',
            'recommended_recipes' => 'Soto Mata Kambing Madura, Sup Bola Mata, Tengkleng Kepala.',
            'utilization_details' => 'Diolah menjadi Soto Mata khas Madura & Tengkleng Solo.',
            'icon' => 'fa-eye',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'kambing',
            'body_part' => 'Kepala & Otak Kambing',
            'part_category' => 'kuliner',
            'pos_x' => 39,
            'pos_y' => 28,
            'benefits' => 'Tinggi kalsium, omega-3, dan protein halus untuk kesehatan otak.',
            'recommended_recipes' => 'Gulai Kepala Utuh, Gulai Otak Kambing, Sup Kepala Bening.',
            'utilization_details' => 'Diolah menjadi Gulai Kepala Kambing Utuh dan Gulai Otak khas Aqiqah.',
            'icon' => 'fa-brain',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'kambing',
            'body_part' => 'Leher & Karkas',
            'part_category' => 'kuliner',
            'pos_x' => 46,
            'pos_y' => 45,
            'benefits' => 'Daging berserat kuat, kaya zat besi untuk pemulihan stamina.',
            'recommended_recipes' => 'Sop Leher Kambing Rempah, Rawon Daging Leher, Semur Kecap.',
            'utilization_details' => 'Diolah menjadi kaldu pekat sup leher dan semur.',
            'icon' => 'fa-bone',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'kambing',
            'body_part' => 'Daging Punggung (Loin)',
            'part_category' => 'kuliner',
            'pos_x' => 63,
            'pos_y' => 44,
            'benefits' => 'Serat daging paling halus, empuk tanpa lemak tinggi.',
            'recommended_recipes' => 'Steak Kambing Grill, Rabeg Banten, Chop BBQ.',
            'utilization_details' => 'Potongan kelas wahid untuk Steak dan Rabeg khas Banten.',
            'icon' => 'fa-utensils',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'kambing',
            'body_part' => 'Daging Iga (Ribs)',
            'part_category' => 'kuliner',
            'pos_x' => 55,
            'pos_y' => 52,
            'benefits' => 'Marbling gurih, tinggi zinc untuk imunitas dan metabolisme.',
            'recommended_recipes' => 'Tongseng Kambing Pedas, Iga Bakar Kecap, Sop Iga Rempah.',
            'utilization_details' => 'Bagian utama pilihan pesta Aqiqah dan olahan Tongseng.',
            'icon' => 'fa-fire-burner',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'kambing',
            'body_part' => 'Kulit & Perut Kambing',
            'part_category' => 'kerajinan',
            'pos_x' => 65,
            'pos_y' => 66,
            'benefits' => 'Kulit lentur dan serat rapat yang sangat kuat setelah diproses.',
            'recommended_recipes' => 'Kerupuk Kulit (Rambak) Kambing, Kikil Rebus Pedas.',
            'utilization_details' => 'Membran Rebana/Hadroh, Kulit Bedug Masjid, Jaket Kulit, Dompet, Sepatu, dan Rambak.',
            'icon' => 'fa-drum',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'kambing',
            'body_part' => 'Jeroan & Hati (Organs)',
            'part_category' => 'kuliner',
            'pos_x' => 61,
            'pos_y' => 58,
            'benefits' => 'Kaya zat besi heme dan asam folat penambah darah alami.',
            'recommended_recipes' => 'Sambal Goreng Hati Kambing, Babat Iso Gulai, Sate Ati.',
            'utilization_details' => 'Bahan baku Sambal Goreng Hati Aqiqah & Sate Ati.',
            'icon' => 'fa-heart',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'kambing',
            'body_part' => 'Kaki Depan (Front Legs)',
            'part_category' => 'kuliner',
            'pos_x' => 49,
            'pos_y' => 77,
            'benefits' => 'Daging padat berserat dengan tendon kolagen tinggi.',
            'recommended_recipes' => 'Soto Kikil Paha Depan, Oseng Daging Kaki.',
            'utilization_details' => 'Bahan baku Soto Kikil & Oseng Pedas Kaki.',
            'icon' => 'fa-paw',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'kambing',
            'body_part' => 'Paha Belakang (Rump/Leg)',
            'part_category' => 'kuliner',
            'pos_x' => 74,
            'pos_y' => 56,
            'benefits' => 'Daging padat lean meat tanpa lemak berlebih, pembentuk otot utama.',
            'recommended_recipes' => 'Sate Kambing Madura / Solo, Kambing Guling Utuh, Nasi Goreng Kambing.',
            'utilization_details' => 'Daging serat padat terbaik khusus Sate dan Kambing Guling.',
            'icon' => 'fa-drumstick-bite',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'kambing',
            'body_part' => 'Kuku & Teracak Kaki (Trotters)',
            'part_category' => 'kuliner',
            'pos_x' => 57,
            'pos_y' => 93,
            'benefits' => 'Kaya akan kalsium, gelatin sendi, dan kolagen alami.',
            'recommended_recipes' => 'Sop Kikil Teracak Kuku Kambing, Tumis Kikil Kuku Pedas.',
            'utilization_details' => 'Diolah menjadi Sup Kikil Kuku Kambing dan Gelatin Alami kuku.',
            'icon' => 'fa-shoe-prints',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'kambing',
            'body_part' => 'Buntut Kambing',
            'part_category' => 'kuliner',
            'pos_x' => 79,
            'pos_y' => 49,
            'benefits' => 'Kaya gelatin alami penambah stamina dan pemulih sendi.',
            'recommended_recipes' => 'Sop Buntut Kambing Rempah Jawa, Buntut Bakar Madu, Tumis Balado Buntut.',
            'utilization_details' => 'Diolah menjadi Sup Buntut aroma rempah pekat berkaldu tinggi.',
            'icon' => 'fa-bone',
        ]);


        // ================= SAPI =================
        AnimalHotspot::create([
            'animal_type' => 'sapi',
            'body_part' => 'Tanduk Sapi',
            'part_category' => 'kerajinan',
            'pos_x' => 21,
            'pos_y' => 12,
            'benefits' => 'Bahan tanduk keras bermotif alami unik di atas kepala sapi.',
            'recommended_recipes' => 'Hiasan Seni & Kerajinan.',
            'utilization_details' => 'Diolah menjadi Gagang Pintu Seni, Sisir Tanduk, Pipa Kerajinan, dan Gagang Pisau.',
            'icon' => 'fa-gem',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'sapi',
            'body_part' => 'Mata Sapi',
            'part_category' => 'kuliner',
            'pos_x' => 23,
            'pos_y' => 29,
            'benefits' => 'Tinggi protein halus, kolagen murni, dan Vitamin B12 tepat pada bola mata sapi.',
            'recommended_recipes' => 'Soto Mata Sapi Madura, Sup Kolagen Mata, Rawon Kikil Kepala.',
            'utilization_details' => 'Diolah menjadi Soto Mata Sapi khas Madura dan campuran Rawon.',
            'icon' => 'fa-eye',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'sapi',
            'body_part' => 'Lidah & Kepala Sapi',
            'part_category' => 'kuliner',
            'pos_x' => 26,
            'pos_y' => 34,
            'benefits' => 'Lidah kaya akan otot empuk dan vitamin B kompleks.',
            'recommended_recipes' => 'Bistik Lidah Saus Tiram, Gullai Otak Sapi, Soto Kepala.',
            'utilization_details' => 'Diolah menjadi Bistik Lidah Sapi berkelas resto.',
            'icon' => 'fa-head-side-mask',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'sapi',
            'body_part' => 'Daging Punggung (Sirloin/Ribeye)',
            'part_category' => 'kuliner',
            'pos_x' => 52,
            'pos_y' => 22,
            'benefits' => 'Protein tinggi (26g/100g) dengan marbling juicy alami sepanjang tulang punggung.',
            'recommended_recipes' => 'Steak Ribeye Grill, Rendang Sapi Padang, Empal Gentong.',
            'utilization_details' => 'Potongan kelas wahid untuk Steak, Rendang Kurban, dan Empal.',
            'icon' => 'fa-drumstick-bite',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'sapi',
            'body_part' => 'Daging Iga Sapi (Ribs)',
            'part_category' => 'kuliner',
            'pos_x' => 44,
            'pos_y' => 44,
            'benefits' => 'Tinggi zat besi heme mudah diserap tubuh dan omega-3.',
            'recommended_recipes' => 'Konro Bakar Makassar, Sop Iga Asam Pedas, Steak Iga.',
            'utilization_details' => 'Diolah menjadi Konro Bakar Makassar dan Sop Iga.',
            'icon' => 'fa-utensils',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'sapi',
            'body_part' => 'Kulit Sapi (Leather)',
            'part_category' => 'kerajinan',
            'pos_x' => 56,
            'pos_y' => 62,
            'benefits' => 'Kulit sapi paling tebal dan paling kuat seratnya di dunia.',
            'recommended_recipes' => 'Kerupuk Rambak Sapi, Krecek Gudeg, Tumis Kikil Cabai Hijau.',
            'utilization_details' => 'Membran Bedug Utama Masjid, Sepatu/Tas Kulit Mewah, Jaket Motor, Kerupuk Krecek Rambak.',
            'icon' => 'fa-drum',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'sapi',
            'body_part' => 'Jeroan & Babat (Tripe)',
            'part_category' => 'kuliner',
            'pos_x' => 64,
            'pos_y' => 50,
            'benefits' => 'Tinggi zat besi, kalsium, dan fosfor penambah metabolisme.',
            'recommended_recipes' => 'Gulai Babat Iso Sapi, Soto Babat Madura, Paru Goreng Renyah.',
            'utilization_details' => 'Bahan baku Soto Babat, Paru Goreng, & Gulai Iso.',
            'icon' => 'fa-heart',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'sapi',
            'body_part' => 'Kaki Depan Sapi (Front Shank)',
            'part_category' => 'kuliner',
            'pos_x' => 38,
            'pos_y' => 72,
            'benefits' => 'Otot betis kaya akan jaringan ikat kolagen pekat.',
            'recommended_recipes' => 'Soto Kikil Kaki Sapi, Oseng Mercon Kaki Sapi.',
            'utilization_details' => 'Diolah menjadi Soto Kikil Kaki Sapi.',
            'icon' => 'fa-paw',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'sapi',
            'body_part' => 'Paha Belakang (Rump)',
            'part_category' => 'kuliner',
            'pos_x' => 76,
            'pos_y' => 52,
            'benefits' => 'Daging serat otot padat, rendah lemak pada paha rump.',
            'recommended_recipes' => 'Rendang Sapi Padang, Semur Sapi Kecap, Bakso Sapi Super.',
            'utilization_details' => 'Bahan baku utama Rendang Padang dan adonan Bakso Sapi.',
            'icon' => 'fa-fire-burner',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'sapi',
            'body_part' => 'Kuku & Teracak Kaki Sapi (Kikil)',
            'part_category' => 'kuliner',
            'pos_x' => 74,
            'pos_y' => 86,
            'benefits' => 'Kikil kuku sapi sangat kaya akan gelatin pelapis lambung & sendi.',
            'recommended_recipes' => 'Mie Kocok Bandung Kikil Sapi, Sup Kuku Kikil, Oseng Kikil Pedas.',
            'utilization_details' => 'Bahan utama Mie Kocok Bandung & Kerajinan Gelatin Makanan.',
            'icon' => 'fa-shoe-prints',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'sapi',
            'body_part' => 'Buntut Sapi (Ox Tail)',
            'part_category' => 'kuliner',
            'pos_x' => 88,
            'pos_y' => 42,
            'benefits' => 'Kolagen tinggi penguat sendi, elastisitas kulit, dan energi di ekor belakang.',
            'recommended_recipes' => 'Sop Buntut Sapi Rempah Spesial, Buntut Bakar Balado, Sop Buntut Kuah Asam.',
            'utilization_details' => 'Bahan baku Sop Buntut favorit resto bintang lima.',
            'icon' => 'fa-bone',
        ]);


        // ================= DOMBA =================
        AnimalHotspot::create([
            'animal_type' => 'domba',
            'body_part' => 'Tanduk Domba Garut',
            'part_category' => 'kerajinan',
            'pos_x' => 24,
            'pos_y' => 14,
            'benefits' => 'Tanduk melingkar indah dengan estetika dan nilai seni tinggi.',
            'recommended_recipes' => 'Penyajian Kontes Lomba & Hiasan.',
            'utilization_details' => 'Barang Koleksi Seni, Hiasan Dinding Mewah, Sisir Tanduk, Gagang Keris Seni.',
            'icon' => 'fa-trophy',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'domba',
            'body_part' => 'Mata Domba',
            'part_category' => 'kuliner',
            'pos_x' => 23,
            'pos_y' => 28,
            'benefits' => 'Kaya sumsum tulang lembut dan kalsium.',
            'recommended_recipes' => 'Tengkleng Kepala Domba Sunda, Sup Kepala Bumbu Kuning, Rabeg Domba.',
            'utilization_details' => 'Diolah menjadi Tengkleng Garut & Sup Kepala tradisional.',
            'icon' => 'fa-eye',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'domba',
            'body_part' => 'Wool & Kulit Domba',
            'part_category' => 'kerajinan',
            'pos_x' => 52,
            'pos_y' => 58,
            'benefits' => 'Serat wol domba menghasilkan kehangatan dan kelembutan ekstra tinggi.',
            'recommended_recipes' => 'Kerupuk Kulit Domba Rambak.',
            'utilization_details' => 'Benang Wol Halus, Sweater/Pakaian Hangat, Sajadah Wol, Sarung Tangan, Jaket Kulit, Rebana.',
            'icon' => 'fa-shirt',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'domba',
            'body_part' => 'Dada & Iga Domba',
            'part_category' => 'kuliner',
            'pos_x' => 44,
            'pos_y' => 44,
            'benefits' => 'Rasa manis gurih lembut, kaya magnesium penenang syaraf.',
            'recommended_recipes' => 'Kare / Curry Domba Santan, Tongseng Domba Solo, Chops Grill.',
            'utilization_details' => 'Menu favorit Tongseng Domba dan Curry Santan Gurih.',
            'icon' => 'fa-utensils',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'domba',
            'body_part' => 'Kaki & Teracak Kuku Domba',
            'part_category' => 'kuliner',
            'pos_x' => 74,
            'pos_y' => 84,
            'benefits' => 'Kikil kuku domba kaya gelatin alami.',
            'recommended_recipes' => 'Sup Kikil Kuku Domba, Oseng Kuku Pedas.',
            'utilization_details' => 'Diolah menjadi Sup Kikil Kuku Domba.',
            'icon' => 'fa-shoe-prints',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'domba',
            'body_part' => 'Paha Domba',
            'part_category' => 'kuliner',
            'pos_x' => 75,
            'pos_y' => 50,
            'benefits' => 'Daging juicy beraroma gurih khas, tinggi L-Carnitine.',
            'recommended_recipes' => 'Nasi Kebuli Daging Domba, Sate Klatak Jogja, Domba Oven Arabia.',
            'utilization_details' => 'Bahan khas Nasi Kebuli, Sate Klatak, dan Domba Oven.',
            'icon' => 'fa-fire-burner',
        ]);

        AnimalHotspot::create([
            'animal_type' => 'domba',
            'body_part' => 'Buntut Domba',
            'part_category' => 'kuliner',
            'pos_x' => 87,
            'pos_y' => 38,
            'benefits' => 'Lemak manis alami yang meleleh memperlezat aroma masakan.',
            'recommended_recipes' => 'Sop Buntut Domba Kebuli, Buntut Domba Bakar Rempah.',
            'utilization_details' => 'Campuran aroma gurih pekat Nasi Kebuli & Sup Buntut Arab.',
            'icon' => 'fa-bone',
        ]);
    }
}
