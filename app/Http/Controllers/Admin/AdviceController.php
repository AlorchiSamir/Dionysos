<?php

namespace App\Http\Controllers\Admin;

use App\Models\Advice;

use App\Repositories\AdviceRepository;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdviceController extends Controller
{    
    public function index(AdviceRepository $adviceRepository){
        $advices = $adviceRepository->getByStatus(Advice::REPORTED);
    	return view('admin.advices.index', compact('advices'));
    }

}