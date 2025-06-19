<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Professional;
use App\Models\Professional\Video;
use App\Models\Tools\Message;

use App\Repositories\Professional\VideoRepository;

class VideoController extends Controller
{
    public function index(VideoRepository $videoRepository){
        $videos = $videoRepository->getLast(20);
        return view('professionals.videos.index', compact('videos'));
    }

    public function edit(Request $request, VideoRepository $videoRepository){
    	if($request->isMethod('post')){
    		$professional = Professional::getCurrent();    		
            $url = Video::formatage($request->url);
            $datas = [
                'url' => $url,
                'professional_id' => $professional->id
            ];
            $videoRepository->save($datas);
            Message::getInstance()->add(__('success_video'), 1);
            return redirect('settings');
        }
        $type = 'video';
    	return view('professionals.videos.edit', compact('type'));
    }
}
