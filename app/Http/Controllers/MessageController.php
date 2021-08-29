<?php

namespace App\Http\Controllers;

use App\Events\SendMessageEvent;
use App\Models\Conversation;
use App\Models\Users\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Http\Response;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {

        $message = Message::create([
            'sender_id'=>auth()->user()->getAuthIdentifier(),
            'conversation_id'=>$request->conversation_id,
            'text'=>$request->text
        ]);
        SendMessageEvent::dispatch($message);
        return \response()->json(['done']);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request)
    {
        $conversation = Conversation::findOrFail($request->conversation_id);
        $messages = $conversation->messages;
        foreach($messages as $message){
            $profilePic = User::findOrFail($message->sender_id)->photo()
                ->where('photo_type','=','profile')
                ->where('current','=','1')->first();
            if($profilePic) {
                $message->profilePic = $profilePic->url;
            }
            if($message->sender_id == auth()->user()->id){
                $message->own = true;
            }else{
                $message->own = false;
            }
        }
        return $messages;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $message =Message::find($request->id);
        $message->text_body=$request->text_body;
        $message->save();
        return \response()->json(['done']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        $message=Message::find($request->id);
        $message->delete();
        return \response()->json(['done']);
    }
}
