<?php

namespace App\Http\Controllers\Admin;

use App\Models\Metier;
use App\Models\Tools\Tools;

use App\Repositories\MetierRepository;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MetierController extends Controller
{
      
    public function index(MetierRepository $metierRepository){
        $metiers = $metierRepository->getAll();
    	return view('admin.metiers.index', compact('metiers'));
    }

    public function create(Request $request){
        if($request->isMethod('post')){
            $datas = [
                'name' => $request->name,
                'color' =>$request->color
            ];
            $metierRepository = new MetierRepository(new Metier());
            $metierRepository->save($datas);
            return redirect('admin/metier');
        }
    	return view('admin.metiers.edit');
    }

    public function view($id){
        $books = Book::where('category_id', '=', $id);
    	return view('admin.book.index');
    }

    public function update($id, Request $request){
        $metierRepository = new MetierRepository(new Metier());
        $metier = $metierRepository->getById($id);
        $slug = Tools::Slugify($request->name);
        if($request->isMethod('post')){
            $metier->name = $request->name;
            $metier->color = $request->color;          
            $metier->update();
            return redirect('admin/metier');
        }
    	return view('admin.metiers.edit', compact('metier'));
    }
}
