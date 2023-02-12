<?php

namespace App\Http\Controllers;

use App\Events\AcceptSubUser;
use App\Events\AcceptUser;
use App\Models\Message;
use App\Models\Notify;
use Illuminate\Support\Facades\DB;
use App\Models\Friend;
use App\Models\User;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Events\PrivateMessageSent;
use App\Events\NotifyEvent;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Cast\Object_;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function changestatemsg($active_id)
    {
        // change state of message to READ
        Message::where('user_id', $active_id)->where('receiver_id', Auth::user()->id)->update(['read' => true]);
    }
    public function getmessage()
    {
        $message = Message::where('read', 0)->get();
        return response()->json($message);
    }
    public function privatemessage(User $user)
    {

        // change state of message to READ
        Message::where('user_id', $user->id)->where('receiver_id', Auth::user()->id)->update(['read' => true]);

        $privatemessage = Message::with('user')
            ->where(['user_id' => Auth::user()->id, 'receiver_id' => $user->id])->orWhere(
                function ($query) use ($user) {
                    $query->where(['user_id' => $user->id, 'receiver_id' => Auth::user()->id]);
                }
            )
            ->get();


        $userchat = User::join('profile', 'profile.user_id', 'users.id')->where('users.id', $user->id)->get();


        return response()->json([
            'messages' => $privatemessage,
            'userchat' => $userchat
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return view('auth.login');
    }
    public function profile()
    {
        return view('component.profile');
    }
    public function users()
    {

        $id = Auth::user()->id;

        $friend1 = DB::table('friends')->leftJoin('users', 'users.id', 'friends.friend_id')
            ->join('profile', 'profile.user_id', 'users.id')
            ->where('type', 1)
            ->where('friends.user_id',  $id)
            ->get();

        $friend2 = DB::table('friends')->leftJoin('users', 'users.id', 'friends.user_id')
            ->join('profile', 'profile.user_id', 'users.id')
            ->where('type', 1)
            ->where('friend_id', $id)
            ->get();

        $friend = array_merge($friend1->toArray(), $friend2->toArray());

        $friend = collect($friend);

        $count_unread = Message::select(DB::raw('user_id as "sender_id", count(user_id) as "message_count"'))
        ->where('receiver_id', Auth::user()->id)
        ->where('read', false)
        ->groupBy('user_id')
        ->get();

        $friend = $friend->map(function($contact) use ($count_unread){
            $contactUnread = $count_unread->where('sender_id', $contact->id)->first();

            $contact->unread = $contactUnread ? $contactUnread->message_count : 0;

            return $contact;
            
        });
        

        return response()->json($friend);
    }

    public function sendmessage(Request $req)
    {
        $msg = auth()->user()->message()->create(['message' => $req->message]);

        broadcast(new MessageSent(auth()->user(), $msg->load('user')))->toOthers();

        return response(['status' => 'message send successfully']);
    }
    public function search(Request $req)
    {
        if ($req->keywords != '') {
            $id = Auth::user()->id;

            $friend1 = DB::table('friends')->leftJoin('users', 'users.id', 'friends.friend_id')
                ->join('profile', 'profile.user_id', 'users.id')
                ->where('type', 1)
                ->where('friends.user_id',  $id)
                ->where('profile.displayName', 'LIKE', '%' . $req->keywords . '%')
                ->get();

            $friend2 = DB::table('friends')->leftJoin('users', 'users.id', 'friends.user_id')
                ->join('profile', 'profile.user_id', 'users.id')
                ->where('type', 1)
                ->where('friend_id', $id)
                ->where('profile.displayName', 'LIKE', '%' . $req->keywords . '%')
                ->get();

            $friend = array_merge($friend1->toArray(), $friend2->toArray());

            return response()->json(
                $friend
            );
        } else if (empty($req->keywords)) {
            $id = Auth::user()->id;

            $friend1 = DB::table('friends')->leftJoin('users', 'users.id', 'friends.friend_id')
                ->join('profile', 'profile.user_id', 'users.id')
                ->where('type', 1)
                ->where('friends.user_id',  $id)
                ->get();

            $friend2 = DB::table('friends')->leftJoin('users', 'users.id', 'friends.user_id')
                ->join('profile', 'profile.user_id', 'users.id')
                ->where('type', 1)
                ->where('friend_id', $id)
                ->get();

            $friend = array_merge($friend1->toArray(), $friend2->toArray());
            return response()->json(
                $friend
            );
        }
    }
    public function currentuser()
    {
        $currentuser = auth()->user();

        return response()->json($currentuser);
    }
    public function activeuser(Request $req)
    {
        $activeId = $req->activeuser;
        return view('layouts.masterlayout')->with('activeId', $activeId);
    }
    public function deletemessage()
    {

        $msg = auth()->user()->message()->where('id', $id)->delete();

        return response(['status' => 'message delete successfully']);
    }
    public function chatindex()
    {
        return view('layouts.masterlayout');
    }
    public function sendprivatemessage(Request $req, User $user)
    {
        $inputdata = $req->all();
        $inputdata['receiver_id'] = $user->id;

        $message = auth()->user()->message()->create(
            $inputdata
        );


        broadcast(new PrivateMessageSent($message->load('user')))->toOthers();


        return response(['status' => 'message send successfully', 'message' => $message]);
    }
    public function friendrequest(Request $req)
    {
        $user = User::where('email', 'LIKE', '%' . $req->email . '%')->first();

        if ($user != null) {
            $id = $user->id;
        } else {
            return response(['error' => 'Sorry! No user found']);
            die;
        }

        if ($id == Auth::user()->id)
        {
            return response(['selferror' => 'Can not send request to yourself!']);
        }
        
        $friend1 = DB::table('friends')->leftJoin('users', 'users.id', 'friends.friend_id')
            ->join('profile', 'profile.user_id', 'users.id')
            ->where('type', 1)
            ->where('friends.user_id',  $id)
            ->where('friends.friend_id', Auth::user()->id)
            ->get();

        $friend2 = DB::table('friends')->leftJoin('users', 'users.id', 'friends.user_id')
            ->join('profile', 'profile.user_id', 'users.id')
            ->where('type', 1)
            ->where('friend_id', $id)
            ->where('friends.user_id', Auth::user()->id)
            ->get();

        $friend3 = DB::table('friends')->leftJoin('users', 'users.id', 'friends.friend_id')
            ->join('profile', 'profile.user_id', 'users.id')
            ->where('type', 0)
            ->where('friends.user_id',  $id)
            ->where('friends.friend_id', Auth::user()->id)
            ->get();

        $friend4 = DB::table('friends')->leftJoin('users', 'users.id', 'friends.user_id')
            ->join('profile', 'profile.user_id', 'users.id')
            ->where('type', 0)
            ->where('friend_id', $id)
            ->where('friends.user_id', Auth::user()->id)
            ->get();

        $checkfriend1 = array_merge($friend1->toArray(), $friend2->toArray());
        $checkfriend2 = array_merge($friend3->toArray(), $friend4->toArray());

        // dd($checkfriend1, $checkfriend2);
        // dd($condall);

        if ($checkfriend1 != null && $checkfriend2 == null) {
            return response(['exist' => 'You guys have been friends, please check again']);
        } else if ($checkfriend1 == null && $checkfriend2 != null) {

            return response(['waiting' => 'Please wait for the user accept your friend request']);
        } else if ($checkfriend1 == null && $checkfriend2 == null) {

            $input['receiver_id'] = $id;
            $input['content'] = 'Send you a friend request';
            $data = auth()->user()->notify()->create($input);



            Friend::create([
                'user_id' => Auth::user()->id,
                'friend_id' => $id
            ]);




            broadcast(new NotifyEvent($data->load('user')))->toOthers();

            return response(['status' => 'Request successfully sent!']);
        }
    }
    public function deletefriend($id)
    {

        $delete = Friend::where(function ($query) use ($id) {
            $query->where('user_id', Auth::user()->id)
                ->Where('friend_id', $id);
        })->orWhere(function ($query) use ($id) {
            $query->where('user_id', $id)
                ->Where('friend_id', Auth::user()->id);
        })->delete();

        Message::where('receiver_id', $id)
            ->where('user_id', Auth::user()->id)
            ->delete();

        Message::where('receiver_id', Auth::user()->id)
            ->where('user_id', $id)
            ->delete();



        if ($delete) {
            return response(['success' => 'Unfriend successfully!']);
        } else {
            return response(['error' => 'Opps! something went wrong']);
        }
    }
    public function accept($id, Request $req)
    {
        // Step 1. Delete old notification and then update state of relationship
        Notify::where('id', $id)->delete();
        Friend::where('user_id', $req->userid)->where('friend_id', Auth::user()->id)->update([
            'type' => 1
        ]);


        // Step 2. Query to make sure you'll get the result that have sender and receiver
        $Friendship = Friend::with('user')->with('subuser')->with('profile')
              ->whereIn('user_id', [Auth::user()->id, $req->userid])
              ->whereIn('friend_id', [Auth::user()->id, $req->userid])
              ->where('type', 1)
              ->first();

        
        // Step 3. I'll merge result from User model and Profile model to array
        $friend = array_merge($Friendship['user']->toArray(), $Friendship['profileuser']->toArray());
        $subfriend = array_merge($Friendship['subuser']->toArray(), $Friendship['profilesubuser']->toArray());


        // Step 4. Convert these array to Object (because the argument of broadcast function need an Object)
        $friend = (object) $friend;
        $subfriend = (object) $subfriend;


        // Final step. After that, send all data to events class

        broadcast(new AcceptUser($friend, $Friendship['user_id']));
        broadcast(new AcceptSubUser($subfriend, $Friendship['friend_id']));

        return response(['status' => 'friend accept successfully']);
    }
    public function remove(Request $req)
    {

        $noti = $req->noti;
        $uid = $req->uid;
        $noti = Notify::where('id', $noti)->delete();

        $delete = Friend::where(function ($query) use ($uid) {
            $query->where('user_id', Auth::user()->id)
                ->Where('friend_id', $uid);
        })->orWhere(function ($query) use ($uid) {
            $query->where('user_id', $uid)
                ->Where('friend_id', Auth::user()->id);
        })->delete();
    }
    public function getnotify()
    {
        $notify = Notify::with('user')->where('receiver_id', Auth::user()->id)->where('status', 0)->get();

        return response()->json($notify);
    }
}
