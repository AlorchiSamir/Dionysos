<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

use App\Models\Professional;
use App\Models\Company;
use App\Models\Hall;

use App\Repositories\ProfessionalRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\HallRepository;

class Interaction extends Model{

	protected $table = 'user_interactions'; 

  const TYPE_LIKE = 'like';
  const TYPE_INTEREST = 'interest';
  const TYPE_VOTE = 'vote';

  const OBJECT_PROFESSIONAL = 'professional';
  const OBJECT_HALL = 'hall';
  const OBJECT_COMPANY = 'company';
  const OBJECT_ADVICE = 'advice';

  public static $types = [
    self::TYPE_LIKE,
    self::TYPE_INTEREST,
    self::TYPE_VOTE
  ];

  public static $objects = [
    self::OBJECT_PROFESSIONAL,
    self::OBJECT_HALL,
    self::OBJECT_COMPANY,
    self::OBJECT_ADVICE
  ];

	public function user(){
    return $this->belongsTo('App\Models\User');
  }     

  public static function insert($datas){
      $interaction = new self();
      $interaction->type = $datas['type'];
      $interaction->user_id = $datas['user_id'];
      $interaction->object_id = $datas['object_id'];
      $interaction->object_type = $datas['object_type'];
      $interaction->value = 1;
      $interaction->save();
  } 

  public function getObject(){    
    if($this->object_type == self::OBJECT_PROFESSIONAL){
      $professionalRepository = new ProfessionalRepository(new Professional);
      return $professionalRepository->getById($this->object_id);
    }
    elseif($this->object_type == self::OBJECT_COMPANY){
      $companyRespository = new CompanyRepository(new Company);
      return $companyRespository->getById($this->object_id);
    }
    elseif($this->object_type == self::OBJECT_HALL){
      $hallRespository = new HallRepository(new Hall);
      return $hallRespository->getById($this->object_id);
    }
    
  } 
}