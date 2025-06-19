<?php

namespace App\Repositories\Professional;

use App\Repositories\RepositoryInterface;

use App\Models\Professional\Video;

class VideoRepository implements RepositoryInterface
{

    protected $video;

	public function __construct(Video $video){
		$this->video = $video;
	}

	public function save($datas){
        $this->video->url = $datas['url'];
        $this->video->professional_id = $datas['professional_id'];
        $this->video->source = 'YOUTUBE';
        $this->video->order = 1;
        $this->video->save();
	}

	public function getById($id){
		return $this->video->findOrFail($id);
	}

	public function getAll(){
		return $this->video->all();
	}

	public function getLast($n){
		return $this->video->take($n)->orderBy('created_at', 'DESC')->get();
	}

}