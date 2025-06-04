<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('addresses')->insert([
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Bastos', 'latitude' => 3.8785, 'longitude' => 11.5156, 'fees' => 2000],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Melen', 'latitude' => 3.8572, 'longitude' => 11.4857, 'fees' => 1500],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Etoudi', 'latitude' => 3.8961, 'longitude' => 11.5249, 'fees' => 1500],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Nlongkak', 'latitude' => 3.8725, 'longitude' => 11.5142, 'fees' => 1000],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Ngoa-Ekelle', 'latitude' => 3.8656, 'longitude' => 11.5016, 'fees' => 1500],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Tsinga', 'latitude' => 3.8660, 'longitude' => 11.5208, 'fees' => 1500],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Ngousso', 'latitude' => 3.8780, 'longitude' => 11.5273, 'fees' => 1500],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Ekounou', 'latitude' => 3.8375, 'longitude' => 11.5406, 'fees' => 2000],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Essos', 'latitude' => 3.8739, 'longitude' => 11.5483, 'fees' => 1000],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Biyem-Assi', 'latitude' => 3.8295, 'longitude' => 11.4844, 'fees' => 1500],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Obili', 'latitude' => 3.8661, 'longitude' => 11.4889, 'fees' => 1500],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Mvog-Mbi', 'latitude' => 3.8539, 'longitude' => 11.5167, 'fees' => 1000],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Damas', 'latitude' => 3.8496, 'longitude' => 11.5540, 'fees' => 1500],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Mokolo', 'latitude' => 3.8576, 'longitude' => 11.5204, 'fees' => 1000],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Mvan', 'latitude' => 3.8167, 'longitude' => 11.5458, 'fees' => 2000],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Briqueterie', 'latitude' => 3.8711, 'longitude' => 11.5083, 'fees' => 1000],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Simbok', 'latitude' => 3.8893, 'longitude' => 11.4815, 'fees' => 2000],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Nsam', 'latitude' => 3.8446, 'longitude' => 11.5321, 'fees' => 1500],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Etoa-Meki', 'latitude' => 3.8782, 'longitude' => 11.5189, 'fees' => 1000],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Essomba', 'latitude' => 3.8742, 'longitude' => 11.5129, 'fees' => 1000],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Olembe', 'latitude' => 3.9243, 'longitude' => 11.4947, 'fees' => 2000],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Mimboman', 'latitude' => 3.8544, 'longitude' => 11.5702, 'fees' => 1500],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Nkoabang', 'latitude' => 3.8744, 'longitude' => 11.5934, 'fees' => 2000],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Nkolbisson', 'latitude' => 3.8567, 'longitude' => 11.4401, 'fees' => 2000],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Mfandena', 'latitude' => 3.8671, 'longitude' => 11.5174, 'fees' => 1000],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Awae', 'latitude' => 3.8410, 'longitude' => 11.5510, 'fees' => 1500],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Carrefour Messassi', 'latitude' => 3.8728, 'longitude' => 11.5329, 'fees' => 1000],
            ['country' => 'Cameroon', 'town' => 'Yaoundé', 'quarter' => 'Ahala', 'latitude' => 3.7967, 'longitude' => 11.5284, 'fees' => 2000],
        ]);
    }
}
