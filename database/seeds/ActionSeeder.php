<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Repositories\UserRepository;

class ActionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $cpt = 1;
        $cpt2 = 1;
        for($i = 1; $i < 40; $i++){
            $userRepository = new UserRepository(new User());
            $user = $userRepository->getById($i);
            if(!$user->isProfessional()){

                for($j = 1; $j < 16; $j++){
                    $f = rand(0, 1);
                    if($f){
                        DB::table('user_interactions')->insert([
                            'id' => $cpt,
                            'user_id' => $i,
                            'object_id' => $j,
                            'object_type' => 'professional',
                            'type' => 'like',
                            'value' => 1
                        ]);
                        $cpt++;
                    }
                } 
                for($j = 1; $j < 16; $j++){
                    $f = rand(0, 1);
                    if($f){
                        DB::table('user_interactions')->insert([
                            'id' => $cpt,
                            'user_id' => $i,
                            'object_id' => $j,
                            'object_type' => 'professional',
                            'type' => 'interest',
                            'value' => 1
                        ]);
                        $cpt++;
                    }
                }
                for($j = 1; $j < 6; $j++){
                    $f = rand(0, 1);
                    if($f){
                        DB::table('user_interactions')->insert([
                            'id' => $cpt,
                            'user_id' => $i,
                            'object_id' => $j,
                            'object_type' => 'hall',
                            'type' => 'like',
                            'value' => 1
                        ]);
                        $cpt++;
                    }
                } 
                for($j = 1; $j < 6; $j++){
                    $f = rand(0, 1);
                    if($f){
                        DB::table('user_interactions')->insert([
                            'id' => $cpt,
                            'user_id' => $i,
                            'object_id' => $j,
                            'object_type' => 'hall',
                            'type' => 'interest',
                            'value' => 1
                        ]);
                        $cpt++;
                    }
                }  
                for($j = 1; $j < 5; $j++){
                    $f = rand(0, 1);
                    if($f){
                        DB::table('user_interactions')->insert([
                            'id' => $cpt,
                            'user_id' => $i,
                            'object_id' => $j,
                            'object_type' => 'company',
                            'type' => 'like',
                            'value' => 1
                        ]);
                        $cpt++;
                    }
                } 
                for($j = 1; $j < 5; $j++){
                    $f = rand(0, 1);
                    if($f){
                        DB::table('user_interactions')->insert([
                            'id' => $cpt,
                            'user_id' => $i,
                            'object_id' => $j,
                            'object_type' => 'company',
                            'type' => 'interest',
                            'value' => 1
                        ]);
                        $cpt++;
                    }
                }
                for($j = 1; $j < 16; $j++){
                    $f = rand(0, 1);
                    if($f){
                        $score = rand(1, 5);
                        DB::table('advices')->insert([
                            'id' => $cpt2,
                            'user_id' => $i,
                            'object_id' => $j,
                            'type' => 'professional',
                            'score' => $score,
                            'comment' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                            'status' => 10
                        ]);
                        $cpt2++;
                    }
                } 
                for($j = 1; $j < 10; $j++){
                    $f = rand(0, 1);
                    if($f){
                        $score = rand(1, 5);
                        DB::table('advices')->insert([
                            'id' => $cpt2,
                            'user_id' => $i,
                            'object_id' => $j,
                            'type' => 'hall',
                            'score' => $score,
                            'comment' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                            'status' => 10
                        ]);
                        $cpt2++;
                    }
                } 
                for($j = 1; $j < 10; $j++){
                    $f = rand(0, 1);
                    if($f){
                        $score = rand(1, 5);
                        DB::table('advices')->insert([
                            'id' => $cpt2,
                            'user_id' => $i,
                            'object_id' => $j,
                            'type' => 'company',
                            'score' => $score,
                            'comment' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                            'status' => 10
                        ]);
                        $cpt2++;
                    }
                }                  
            }            
        }
    }
}
