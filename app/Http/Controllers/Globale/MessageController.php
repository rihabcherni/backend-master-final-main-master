<?php
namespace App\Http\Controllers\Globale;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Resources\MessageResource;
use App\Http\Requests\storeMessageRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MessageController extends Controller{
    public function store(storeMessageRequest $request){
        //  body ,  user_id  ,  conversation_id
        if(Auth::check()){
        $message = new Message();
        $message->body = $request['body'];
        $message->read = false;
        $message->user_id = request()->user()->id;
        $message->conversation_id = $request['conversation_id'];
        $message->save();
        return new MessageResource($message);
        }
    }
}
