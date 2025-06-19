<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;

use App\Repositories\RepositoryInterface;

use App\Models\Message;

class MessageRepository implements RepositoryInterface
{

    protected $message;

	public function __construct(Message $message){
		$this->message = $message;
	}

	public function save($datas){
		$user = Auth::user();		
		$this->message->sender_id = $user->id;
        $this->message->recipient_id = $datas['recipient_id'];
        $this->message->message_id = $datas['message_id'];
        $this->message->title = $datas['title'];
        $this->message->email = $user->email;
        $this->message->content = $datas['content'];
        $this->message->send_time = date('Y-m-d H:i:s');
        $this->message->save();
	}

	public function getById($id){
		return $this->message->findOrFail($id);
	}

	public function getAll(){
		return $this->message->all();
	}

	public function getAllByRecipient($user_id = null){
		if(is_null($user_id)){
			$user_id = Auth::id();
		}
		return $this->message->where('recipient_id', '=', $user_id)->get();
	}

	public function countUnread($user_id = null){
		if(is_null($user_id)){
			$user_id = Auth::id();
		}
		return count($this->message->where('recipient_id', '=', $user_id)->where('view_time', '=', null)->get());
	}

	public function userIsRecipient($message_id){
		$user_id = Auth::id();
		$message = $this->message->where('id', '=', $message_id)->where('recipient_id', '=', $user_id)->first();
		return (is_null($message)) ? false : true;
	}

}