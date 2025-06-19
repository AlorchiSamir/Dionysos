<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Models\Message;
use App\Models\User;
use App\Mail\Message as Mail_Message;

use App\Repositories\MessageRepository;
use App\Repositories\UserRepository;

class MessageController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(MessageRepository $messageRepository){
        $user_id = Auth::id();
        $messages = $messageRepository->getAllByRecipient($user_id);
    	return view('messages.index', compact('messages'));
    }

    public function view($message_id, MessageRepository $messageRepository){
        $isRecipient = $messageRepository->userIsRecipient($message_id);                
        if($isRecipient){
           $message = $messageRepository->getById($message_id);
           if($message->view_time == null){
                $message->view_time = now();
                $message->save();
            }
           return view('messages.view', compact('message'));
        }
        return redirect('/messages');
    }

    public function edit(Request $request){
    	if($request->isMethod('post')){  
            $flag = true;
            $messageRepository = new MessageRepository(new Message());
            if(isset($request->message_id)){
                $message_id = $request->message_id;
                $message = $messageRepository->getById($message_id);
                $isRecipient = $messageRepository->userIsRecipient($message_id);
                if($isRecipient){
                    $recipient_id = $message->sender_id;
                }
                else{
                    $flag = false;
                }
            }
            else{                
                $message_id = null;
                $recipient_id = (isset($request->professional)) ? $request->professional : null;
            }
            if($flag){   
                $title = (isset($request->original_title)) ? 'RE: '.$request->original_title : $request->title;
                $datas = [                
                    'recipient_id' => $recipient_id,
                    'message_id' => $message_id,
                    'title' => $title,      
                    'content' => $request->content
                ];
                $messageRepository->save($datas);
                if(isset($message)){
                    $message->response_time = now();
                    $message->save();
                }
                if(!is_null($recipient_id)){
                    $userRepository = new UserRepository(new User());
                    $user = $userRepository->getById($recipient_id);
                    Mail::to($user->email)->send(new Mail_Message(array('name' => $user->name, 'firstname' => $user->firstname)));
                }
                
            }
        }  
        return ($request->ajax()) ? true : redirect('messages');
    }
    
       
}