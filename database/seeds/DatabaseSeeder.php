<?php

use Illuminate\Database\Seeder;

use App\Models\Tools;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
    		'id' => 1,
            'name' => 'Alorchi',
            'firstname' => 'Samir',
            'tel' => '0499362771',
            'email' => 'samir.alorchi@gmail.com',
            'type' => 'ADMIN',
            'password' => bcrypt('rodney'),
        ]);

        $metiers = [
        	['deejay', '#1256a6', 'person', 1],
            ['musician', '#1256a6', 'person', 2],
            ['animator', '#565232', 'person', 3],
            ['barman', '#565232', 'person', 4],
            ['magician', '#565232', 'person', 5],
            ['caterer', '#565232', 'company', 6],
            ['cleaning', '#565232', 'company', 7],
            ['security', '#565232', 'company', 8],
            ['provider', '#565232', 'company', 9],
            ['communication', '#1256a6', 'company', 10], 
            ['hall_owner', '#1256a6', 'place', 11],

        ];

        $skills = [
        	['Rock', '#1256a6', 1], ['Electro', '#1256a6', 1], ['Rap', '#1256a6', 1], ['Metal', '#1256a6', 1], ['RnB', '#1256a6', 1],
        	['Classique', '#1256a6', 1], ['Variété', '#1256a6', 1], ['Humour', '#1256a6', 1], ['House', '#1256a6', 1],
            ['Solo', '#1256a6', 2], ['Groupe', '#1256a6', 2], ['Karaoké', '#1256a6', 3], ['Danse', '#1256a6', 3],
        	['Cocktail', '#125362', 4], ['Jonglage', '#125362', 4], ['Bière', '#125362', 4], ['Luxe', '#125362', 4], 
            ['Vin', '#125362', 4], ['Soft', '#125362', 4], ['Jeu de cartes', '#125362', 5], ['Illusions', '#125362', 5]
        ];

        foreach ($metiers as $i => $metier) {
        	DB::table('metiers')->insert([
	     		'id' => $i+1, 'name' => $metier[0], 'order' => $metier[3], 'color' => $metier[1], 'type' => $metier[2]
	    	]);
        }

    	foreach ($skills as $i => $skill) {
        	DB::table('metier_skills')->insert([
	     		'id' => $i+1, 'name' => $skill[0], 'color' => $skill[1], 'metier_id' => $skill[2]
	    	]);
        }
    }
}
