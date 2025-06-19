<?php

namespace App\Http\Controllers;

use App\Models\Professional;
use App\Models\Metier;

use App\Repositories\Professional\VideoRepository;

class IndexController extends Controller
{

	public function __construct(){
        $this->middleware('checksettings');
    }
    
    public function index(VideoRepository $videoRepository){
    	$metiers = '';
    	$videos = $videoRepository->getLast(3);
        return view('index.index', compact('metiers', 'videos'));
    }
}