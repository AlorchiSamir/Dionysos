<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\EmailRepository;

class Email extends Model{
    protected $table = 'emails';

    const VALIDITY = 'validity';
    const MESSAGE = 'message';

    public static function insert($recipient, $type){
    	$emailRepository = new EmailRepository(new self);
    	$emailRepository->save([
    		'recipient' => $recipient,
    		'type' => $type
    	]);
    }
}
