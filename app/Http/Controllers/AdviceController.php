<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Advice;
use App\Models\Tools\Message;

use App\Repositories\AdviceRepository;

class AdviceController extends Controller
{

    public function index(AdviceRepository $adviceRepository){
        $advices = $adviceRepository->getByUser();
        return view('advices.index', compact('advices'));
    }

    public function add(Request $request, AdviceRepository $adviceRepository){
    	$user = Auth::user();
    	$type = $request->input('type');
        $score = ($request->input('score') > Advice::SCORE_MAX) ? Advice::SCORE_MAX : $request->input('score');
        $score = ($score < Advice::SCORE_MIN) ? Advice::SCORE_MIN : $score;
    	if(in_array($type, Advice::$types)){
    		$advice = [
    			'user_id' => $user->id,
    			'object_id' =>  $request->input('object'),
    			'type' =>  $type,
    			'comment' => $request->input('comment'),
    			'score' => $score
    		];
    		$adviceRepository->save($advice); 
            Message::getInstance()->add(__('success_advice'), 1);
    		return redirect($_SERVER['HTTP_REFERER']);
    	}
    	return redirect('/');
    }

    public function report(Request $request, AdviceRepository $adviceRepository){
        $advice_id = $_POST['advice_id'];
        $advice = $adviceRepository->getById($advice_id);
        if($advice->status == Advice::POSTED){
            $advice->status = Advice::REPORTED;
            $advice->save();
        }
    }

}