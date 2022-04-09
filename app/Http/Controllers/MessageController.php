<?php

namespace App\Http\Controllers;

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

class MessageController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function getmessage(){
        $message = Message::with('user')->get();


        return response()->json($message);
    }
    public function privatemessage(User $user){

        $privatemessage = Message::with('user')
        ->where(['user_id' => Auth::user()->id, 'receiver_id' => $user->id])->orWhere(
            function($query) use($user){
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
    public function logout(){
        Auth::logout();
        return view('auth.login');
    }
    public function profile(){
        return view('component.profile');
    }
    public function users(){
        // $user = User::with('profile')->get();

        // $user = User::with(['profile','friend' => function($query){
        //     $query
        //     ->orWhere('user_id', Auth::user()->id)
        //     ->orWhere('friend_id',  Auth::user()->id)
        //     ->where('type',1);
        // }])->where('id','!=', Auth::user()->id)->has('friend')->get();


        // foreach($user as $key => $users){
        //     $frienddata = $users->friend;
        //     if(empty($frienddata)){
        //         return response()->json(['']);
        //     }
        //     else{
        //         return response()->json([$users]);
        //     }
        // }

        // $user = User::findOrFail(Auth::user()->id);

        // $user->friend->where('type', 1);

        // foreach($user as $key =>  $person){
        //     $id_friend = $person->friend[$key]->id;

        //     $profile = Profile::where('user_id', $id_friend)->get();

        //     return response()->json([
        //         'user' => $user,
        //         'profile' => $profile
        //     ]);
        // }


        // $user->friend(Auth::user()->id);

        $id = Auth::user()->id;

        $friend1 = DB::table('friends')->leftJoin('users', 'users.id','friends.friend_id')
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


        return response()->json($friend);
        
    }

    public function sendmessage(Request $req){
        $msg = auth()->user()->message()->create(['message' => $req->message]);

        broadcast(new MessageSent(auth()->user(), $msg->load('user')))->toOthers();

        return response(['status' => 'message send successfully']);
    }
    public function search(Request $req){
        if($req->keywords != ''){
            $id = Auth::user()->id;

            $friend1 = DB::table('friends')->leftJoin('users', 'users.id','friends.friend_id')
                        ->join('profile', 'profile.user_id', 'users.id')
                        ->where('type', 1)
                        ->where('friends.user_id',  $id)
                        ->where('profile.displayName', 'LIKE', '%'.$req->keywords.'%')
                        ->get();
    
            $friend2 = DB::table('friends')->leftJoin('users', 'users.id', 'friends.user_id')
                        ->join('profile', 'profile.user_id', 'users.id')
                        ->where('type', 1)
                        ->where('friend_id', $id)
                        ->where('profile.displayName', 'LIKE', '%'.$req->keywords.'%')
                        ->get();
    
            $friend = array_merge($friend1->toArray(), $friend2->toArray());
            
            return response()->json(
               $friend
            ); 
        }
        else if(empty($req->keywords)){
            $id = Auth::user()->id;

            $friend1 = DB::table('friends')->leftJoin('users', 'users.id','friends.friend_id')
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
    public function currentuser(){
        $currentuser = auth()->user();

        return response()->json($currentuser);
    }
    public function activeuser(Request $req){
        $activeId = $req->activeuser;
        return view('layouts.masterlayout')->with('activeId', $activeId);
    }
    public function deletemessage(){
       
        $msg = auth()->user()->message()->where('id', $id)->delete();

        return response(['status' => 'message delete successfully']);
    }
    public function chatindex(){
        return view('layouts.masterlayout');
    }
    public function sendprivatemessage(Request $req, User $user){
        $inputdata = $req->all();
        $inputdata['receiver_id'] = $user->id;

        $message = auth()->user()->message()->create(
            $inputdata
        );

     
            broadcast(new PrivateMessageSent($message->load('user')))->toOthers();
    

        return response(['status' => 'message send successfully','message' => $message]);
    }
    public function friendrequest(Request $req){
        $user = User::where('email','LIKE','%'.$req->email.'%')->first();

        if($user != null){
            $id = $user->id;
        }
        else{
            return response(['error' => 'No user found!']);
            die;
        }
        $uid = Auth::user()->id;
        $friend1 = DB::table('friends')->leftJoin('users', 'users.id','friends.friend_id')
        ->join('profile', 'profile.user_id', 'users.id')
        ->where('type', 1)
        ->where('friends.user_id',  $id)
        ->where('friends.friend_id', Auth::user()->id)
        ->get();

        // $check = Friend::orWhere(function($query) use ($id){
        //     $query->where('user_id', $id)
        //         ->where('friend_id', Auth::user()->id);
        // })->orWhere(function($query) use($id){
        //     $query->where('user_id', Auth::user()->id)
        //         ->where('friend_id', $id);
        // })->where('type', 1)->get();

        $friend2 = DB::table('friends')->leftJoin('users', 'users.id', 'friends.user_id')
        ->join('profile', 'profile.user_id', 'users.id')
        ->where('type', 1)
        ->where('friend_id', $id)
        ->where('friends.user_id', Auth::user()->id)
        ->get();

        $friend3 = DB::table('friends')->leftJoin('users', 'users.id','friends.friend_id')
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

        if($checkfriend1 != null && $checkfriend2 == null ){
            return response(['exist' => 'already friend!']);
        }
        else if($checkfriend1 == null && $checkfriend2 != null)
            {

            return response(['waiting' => 'Please wait for the user to accept the friend request']);
           
            }
        else if($checkfriend1 == null && $checkfriend2 == null){

            $input['receiver_id'] = $id;
            $input['content'] = 'Send you a friend request';
            $data = auth()->user()->notify()->create($input);
    
            Friend::create([
                'user_id'=> Auth::user()->id,
                'friend_id' => $id
            ]);

           
    
            broadcast(new NotifyEvent($data->load('user')))->toOthers();
    
            return response(['status' => 'friend request send successfully']);
           
        }
        
    
    }
    public function deletefriend($id){

        $delete = Friend::where(function($query) use($id){
            $query->where('user_id', Auth::user()->id)
                ->Where('friend_id', $id);
        })->orWhere(function($query) use($id){
            $query->where('user_id', $id)
                ->Where('friend_id', Auth::user()->id);
        })->delete();

        Message::where('receiver_id', $id)
                ->where('user_id', Auth::user()->id)
                ->delete();

        Message::where('receiver_id', Auth::user()->id)
                ->where('user_id', $id)
                ->delete();        

      

        if($delete){
            return response(['success' => 'Unfriend successfully!']);
        }
        else{
            return response(['error' => 'Opps! something went wrong']);
        }

    }
    public function accept($id, Request $req){
        $noti = Notify::where('id', $id)->delete();

        $friendaccept = Friend::where('user_id', $req->userid)->where('friend_id', Auth::user()->id)->update([
            'type' => 1
        ]);

        

        $friend1 = DB::table('friends')->leftJoin('users', 'users.id','friends.friend_id')
        ->join('profile', 'profile.user_id', 'users.id')
        ->where('type', 1)
        ->where('friends.user_id',  Auth::user()->id)
        ->get();

        $friend2 = DB::table('friends')->leftJoin('users', 'users.id', 'friends.user_id')
        ->join('profile', 'profile.user_id', 'users.id')
        ->where('type', 1)
        ->where('friend_id', Auth::user()->id)
        ->get();

        $friend = array_merge($friend1->toArray(), $friend2->toArray());

       
        return response()->json($friend);
    }
    public function remove(Request $req){

        $noti = $req->noti;
        $uid = $req->uid;
        $noti = Notify::where('id',$noti)->delete();
        
        $delete = Friend::where(function($query) use($uid){
            $query->where('user_id', Auth::user()->id)
                ->Where('friend_id', $uid);
        })->orWhere(function($query) use($uid){
            $query->where('user_id', $uid)
                ->Where('friend_id', Auth::user()->id);
        })->delete();
    }
    public function getnotify(){
        $notify = Notify::with('user')->where('receiver_id', Auth::user()->id)->where('status', 0)->get();

        return response()->json($notify);
    }
}
