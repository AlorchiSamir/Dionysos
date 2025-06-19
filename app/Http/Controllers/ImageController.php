<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hall;
use App\Models\Hall\Image;
use App\Models\Tools\Tools;
use App\Models\Tools\Message;

use App\Repositories\Hall\ImageRepository;
use App\Repositories\HallRepository;

class ImageController extends Controller
{
    public function edit($id, $slug, Request $request, ImageRepository $imageRepository){
        $hallRepository = new HallRepository(new Hall);
        $hall = $hallRepository->getById($id);
    	if($request->isMethod('post')){


            $url = ($files = $request->file('image')) ? Tools::UploadImage($files, 'hall') : '';

            $datas = [
                'url' => $url,
                'hall_id' => $id
            ];
            $imageRepository->save($datas);
            Message::getInstance()->add(__('success_image'), 1);
            return redirect('hall/settings/'.$id.'/'.$slug.'/images');
        }
        $type = 'image';
    	return view('halls.images.edit', compact('type', 'hall'));
    }
}
