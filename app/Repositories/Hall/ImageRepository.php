<?php

namespace App\Repositories\Hall;

use App\Repositories\RepositoryInterface;

use App\Models\Hall\Image;

class ImageRepository implements RepositoryInterface
{

    protected $image;

	public function __construct(Image $image){
		$this->image = $image;
	}

	public function save($datas){
        $this->image->url = $datas['url'];
        $this->image->hall_id = $datas['hall_id'];
        $this->image->status = Image::WAITING;
        $this->image->order = 1;
        $this->image->active = true;
        $this->image->save();
	}

	public function getById($id){
		return $this->image->findOrFail($id);
	}

	public function getAll(){
		return $this->image->all();
	}

	public function getLast($n){
		return $this->image->take($n)->get();
	}

}