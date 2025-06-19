<?php

namespace App\Http\Controllers\Admin;

use App\Models\Message;

use App\Repositories\MessageRepository;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{    
    public function index(MessageRepository $messageRepository){
        $messages = $messageRepository->getAllByRecipient();
    	return view('admin.messages.index', compact('messages'));
    }

}
