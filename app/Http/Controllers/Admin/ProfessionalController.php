<?php

namespace App\Http\Controllers\Admin;

use App\Models\Professional;
use App\Models\Tools\Tools;

use App\Repositories\ProfessionalRepository;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfessionalController extends Controller
{
    public function index(ProfessionalRepository $professionalRepository){
        $professionals = $professionalRepository->getByStatus(Professional::WAITING);
    	return view('admin.professionals.index', compact('professionals'));
    }

    public function validated($id, ProfessionalRepository $professionalRepository){
        $professional = $professionalRepository->getById($id);
        if($professional->status == Professional::WAITING){
            $professional->status = Professional::VALIDATED;
            $professional->save();
        }
        return redirect('/admin/professional');
    }
      
}
