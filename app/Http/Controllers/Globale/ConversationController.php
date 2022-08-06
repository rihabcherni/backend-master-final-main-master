<?php

namespace App\Http\Controllers\Globale;
use Illuminate\Support\Facades\Auth;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Http\Resources\ConversationResource;

class ConversationController extends Controller{

    public function index(Request $request){
        $conversations = Conversation::where( function ($query){
            $query->where('user_id', request()->user()->id)
                  ->orWhere('second_user_id', request()->user()->id);
        })->where(function ($query) use($request){
            $query->where('auth_user', $request->auth_user)
                  ->orWhere('auth_second_user', $request->auth_user);
        })->where(function ($query) use($request){
            $query->where('auth_user', $request->auth_second_user)
                  ->orWhere('auth_second_user', $request->auth_second_user);
        })->get();

        $count = count($conversations);

        for ($i = 0; $i < $count; $i++) {
			for ($j = $i + 1; $j < $count; $j++) {
				if (isset($conversations[$i]->messages->last()->id) && isset($conversations[$j]->messages->last()->id) && $conversations[$i]->messages->last()->id < $conversations[$j]->messages->last()->id){
					$temp = $conversations[$i];
					$conversations[$i] = $conversations[$j];
					$conversations[$j] = $temp;
				}
			}
		}
        return ConversationResource::collection($conversations);
    }

    public function getConversationId($id){
        $conversations = Conversation::find($id);
        return new ConversationResource($conversations);
    }

    public function makeConversationAsReaded (Request $request){
        $request->validate([
            'conversation_id' => 'required',
        ]);
        $conversation = Conversation::findOrFail($request['conversation_id']);

        foreach( $conversation->messages as $message){
            $message->update(['read' => true]);
        }
        return response(['success',200]);
    }

    public function store(Request $request){
        if (Auth::check()){
            $conversations = Conversation::where('user_id' ,request()->user()->id)->orWhere('second_user_id',request()->user()->id)->get();
            $bool = false;
            for ($i =0 ; $i < count($conversations) ; $i++){
                if( (($conversations[$i]->user_id == $request->user_id) ||
                    ($conversations[$i]->second_user_id == $request->user_id))&&
                    (($conversations[$i]->auth_user == $request->auth_user) &&
                    ($conversations[$i]->auth_second_user == $request->auth_second_user)) ){
                    $bool = true;
                    $conversation = $conversations[$i];
                    break;
                }
            }
            if($bool){
                $msg=$conversations->messages;
                $compteur=count($conversations->messages);
                for($i = 0;$i < $compteur ; $i++){
                    for ($j = $i + 1; $j < $compteur; $j++) {
                        if (isset($msg[$i]->id) && isset($msg[$j]->id) && $msg[$i]->id < $msg[$j]->id){
                            $temp = $msg[$i];
                            $msg[$i] = $msg[$j];
                            $msg[$j] = $temp;
                        }
                    }
                }
            return response([
                "data"=> new ConversationResource($conversations)
            ],200);
            }else{
                $request->validate([
                    'user_id'=>'required',
                    'auth_user'=>'required',
                    'auth_second_user'=>'required',
                ]);
                $conversation = Conversation::create([
                    'user_id' => request()->user()->id,
                    'second_user_id' => $request['user_id'],
                    'auth_user' => $request['auth_user'],
                    'auth_second_user'=>$request['auth_second_user']
                ]);

                return new ConversationResource($conversation);
            }
        }
        return response([ 'message' => 'error'],403);

    }
}
