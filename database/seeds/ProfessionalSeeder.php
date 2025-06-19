<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\Tools\Tools;
use App\Models\Address;

class ProfessionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

    	$surnames = [
    		['DJ Balai',[1,2,3], 1],['Wondermusic',[3,5,6,7], 1], ['DJ Furious', [1,2,9], 1], ['Super Copter',[2,3,5,6,8], 1],
    		['Gigamax', [1,4,5,6,7,8], 1], ['DJ Francis',[1,2,3,5,7], 1], ['Brouhabam', [2,4], 1], ['DJ Power Max', [3,6,9], 1], 
    		['DJ Javascript', [3,5,8,9], 1], ['Obobo', [5], 1], ['DJ Deejay', [1,2,3,4,5,6,7,8,9], 1], ['Azura', [8,9,10], 1],
    		['David Bowie', [10], 2], ['Beatles', [11], 2], ['Freddy Mercury', [10,11], 2], 
    		['Harry Houdini', [12, 13], 3], ['David Coperfield', [13], 3], ['Merlin', [12], 3], 
    		['Bob Sinclair', [14,15,16], 4], ['Napo', [14, 15], 4], ['Jean Valjean', [14,15,16,17,18], 4]
    	];

    	

    	$surnames3 = [
    		['Jean Dupont', 'Salle des sapins'],
    		['Jean Dupont', 'Salle du Temps'],
    		['Jean Dupont', 'Pourquoi Pas'],
    		['Jean Dupont', 'Orange Givree'],
    		['Jean Dupont', 'Salle de fête'],
    		['Jean Dupont', 'Millenium']
    	];

    	$surnames4 = [
    		['Miam Miam', 6],
    		['Au bon goût', 6],
    		['Bien Propre', 7],
    		['Damien Gérard', 8],
    		['Maes', 9]
    	];

    	$address_id = 1;
        foreach ($surnames as $key => $surname) {
        	
            DB::table('professionals')->insert([
	        	'id' => $key+1,
	            'surname' => $surname[0],
	            'slug' => Tools::Slugify($surname[0]),
	            'user_id' => $key+2,
	            'address_id' => null,
	            'email' => Str::random(10).'@gmail.com',
	            'tel' => Str::random(10),
	            'status' => 20,
	            'address_id' => $address_id,
	            'description' => $description,
	            'website' => 'http://www.jeuxvideo.com',
	            'created_at' => now()

	        ]);	 

	        $address_id++;       

	        DB::table('professional_metier')->insert([
	        	
	            'professional_id' => $key+1,
	            'metier_id' => $surname[2],

	        ]);

	        foreach ($surname[1] as $n) {
	        	DB::table('professional_metier_skill')->insert([	        	
		            'professional_id' => $key+1,
		            'skill_id' => $n,
	        	]);
	        }

	        $value = random_int(10, 200);

	        DB::table('professional_settings')->insert([	        	
		       'professional_id' => $key+1,
		       'setting' => 'distance',
		       'value' => $value
	        ]);

	        $value = random_int(50, 250);

	        DB::table('prices')->insert([	        	
		       'professional_id' => $key+1,
		       'price' => $value,
		       'type' => 'hour',
		       'active' => 1
	        ]);
	        
    	}
    	
    	$address_id2 = 1;
    	foreach ($surnames3 as $key => $surname){
    		DB::table('professionals')->insert([
	        	'id' => $key+21+2+1,
	            'surname' => $surname[0],
	            'slug' => Tools::Slugify($surname[0]),
	            'user_id' => $key+12+2+2,
	            'address_id' => null,
	            'email' => Str::random(10).'@gmail.com',
	            'tel' => Str::random(10),
	            'status' => 20,
	            //'address_id' => $address_id,
	            'description' => null,
	            'website' => null

	        ]);

    		DB::table('professional_metier')->insert([
	        	
	            'professional_id' => $key+13+2+1,
	            'metier_id' => 11,

	        ]);

	        DB::table('halls')->insert([
	        	'id' => $key+1,	
	        	'name' => $surname[1],            
	            'slug' => Tools::Slugify($surname[1]),
	            'professional_id' => $key+12+2+1,	                        
	            'address_id' => $address_id2,
	            'description' => $description,
	            'capacity' => 350,
	            'parking' => true, 
	            'created_at' => now()

	        ]);
	        $address_id2++;
    	}

    	$address_id3 = 1;
    	foreach ($surnames4 as $key => $surname){
    		DB::table('professionals')->insert([
	        	'id' => $key+27+2+1,
	            'surname' => $surname[0],
	            'slug' => Tools::Slugify($surname[0]),
	            'user_id' => $key+18+2+2,
	            'address_id' => null,
	            'email' => Str::random(10).'@gmail.com',
	            'tel' => Str::random(10),
	            'status' => 20,
	            //'address_id' => $address_id,
	            'description' => null,
	            'website' => null, 
	            'created_at' => now()

	        ]);

	        DB::table('professional_metier')->insert([
	        	
	            'professional_id' => $key+19+2+1,
	            'metier_id' => $surname[1],

	        ]);

	        DB::table('companies')->insert([
	        	'id' => $key+1,	
	        	'name' => $surname[0],            
	            'slug' => Tools::Slugify($surname[0]),
	            'professional_id' => $key+12+2+1,	                        
	            'address_id' => $address_id3,
	            'description' => $description,
	            'metier_id' => $surname[1],
	            'status' => 10,
	            'tva_number' => '123456'

	        ]);
	        $address_id3++;
    	}

    	DB::table('professional_videos')->insert([	        	
		    'professional_id' => 1,
		    'source' => 'youtube',
		    'order' => 1,
		    'url' => 'K-aC73qcAmo'
	    ]);

	    DB::table('professional_videos')->insert([	        	
		    'professional_id' => 3,
		    'source' => 'youtube',
		    'order' => 1,
		    'url' => '8tIgN7eICn4'
	    ]);

	    DB::table('professional_videos')->insert([	        	
		    'professional_id' => 5,
		    'source' => 'youtube',
		    'order' => 1,
		    'url' => 'vUYZjeyKQpw'
	    ]);

    	$addressA = [
	        	['country' => 'BE', 'city' => 'Liège', 'postal_code' => '4000', 'street' => 'rue Louvrex 38'],
	        	['country' => 'BE', 'city' => 'Liège', 'postal_code' => '4000', 'street' => 'rue de Fétinne 84'],
	        	['country' => 'BE', 'city' => 'Liège', 'postal_code' => '4000', 'street' => 'rue de la Casquette 17'],
	        	['country' => 'BE', 'city' => 'Waimes', 'postal_code' => '4950', 'street' => 'rue de la Piste 34'],
	        	['country' => 'BE', 'city' => 'Malmedy', 'postal_code' => '4960', 'street' => 'rue de la Warche 10'],
	        	['country' => 'BE', 'city' => 'Malmedy', 'postal_code' => '4960', 'street' => 'rue du Commerce 24'],
	        	['country' => 'BE', 'city' => 'Spa', 'postal_code' => '4900', 'street' => 'rue Deleau 65'],
	        	['country' => 'BE', 'city' => 'Verviers', 'postal_code' => '4800', 'street' => 'rue de Limbourg 57'],
	        	['country' => 'BE', 'city' => 'Verviers', 'postal_code' => '4800', 'street' => 'rue de la Station 3'],
	        	['country' => 'BE', 'city' => 'Mouscron', 'postal_code' => '7700', 'street' => 'rue du Christ 80'],
	        	['country' => 'BE', 'city' => 'Liège', 'postal_code' => '4000', 'street' => 'rue Louvrex 38'],
	        	['country' => 'BE', 'city' => 'Liège', 'postal_code' => '4000', 'street' => 'rue de Fétinne 84'],
	        	['country' => 'BE', 'city' => 'Liège', 'postal_code' => '4000', 'street' => 'rue de la Casquette 17'],
	        	['country' => 'BE', 'city' => 'Waimes', 'postal_code' => '4950', 'street' => 'rue de la Piste 34'],
	        	['country' => 'BE', 'city' => 'Malmedy', 'postal_code' => '4960', 'street' => 'rue de la Warche 10'],
	        	['country' => 'BE', 'city' => 'Malmedy', 'postal_code' => '4960', 'street' => 'rue du Commerce 24'],
	        	['country' => 'BE', 'city' => 'Spa', 'postal_code' => '4900', 'street' => 'rue Deleau 65'],
	        	['country' => 'BE', 'city' => 'Verviers', 'postal_code' => '4800', 'street' => 'rue de Limbourg 57'],
	        	['country' => 'BE', 'city' => 'Verviers', 'postal_code' => '4800', 'street' => 'rue de la Station 3'],
	        	['country' => 'BE', 'city' => 'Mouscron', 'postal_code' => '7700', 'street' => 'rue du Christ 80']
	        ];
	        $cpt = 1;
	        foreach ($addressA as $key => $add) {
	        	$address = new Address();
	        	$address->country = $add['country'];
	        	$address->city = $add['city'];
	        	$address->postal_code = $add['postal_code'];
	        	$address->street = $add['street'];
	        	$address->setPosition();
	        	DB::table('address')->insert([ 
	        		'id' => $cpt, 'country' => $address->country, 'city' => $address->city, 'postal_code' => $address->postal_code,
	        		'street' => $address->street, 'latitude' => $address->latitude, 'longitude' => $address->longitude
	        	]);
	        	$cpt++;
	        }
    }
}
