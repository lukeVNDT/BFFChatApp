<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    public function getotherprofile($id){
        $profile = Profile::where('user_id', $id)->get();

        return response()->json($profile);
    }
    public function otherprofile($id){
        return view('component.otherprofile');
    }
    public function getuser(){
        
        $id = Auth::user()->id;
        $currentuser = User::join('profile', 'profile.user_id', 'users.id')->where('users.id', $id)->get();
        $user = Profile::where('user_id', $id)->get();
        if($user->count() > 0){
            return response()->json([
                'user' => $user,
                'currentUser' => $currentuser
            ]);
        }
        else{
        return response()->json([
            'user' => $user,
            'currentUser' => $currentuser
        ]);
        }
    }
    public function saveprofile(Request $req){
        // dd($req->all());
        $id = Auth::user()->id;
        $user = Profile::where('user_id', $id)->get();
        foreach($user as $person){
            $oldimg = $person->avatar;
        }
        if($user->count() > 0)
        {
            if($req->avatar){
                if($req->avatar != $oldimg){
          
                cloudinary()->destroy($oldimg);
                $result = $req->file('avatar')->storeOnCloudinary('avatarchatproject');
                $name = $result->getFileName();
                    Profile::where('user_id', $id)->update([
                        'user_id' => $id,
                        'displayName' => $req->displayName,
                        'address' => $req->address,
                        'country' => $req->country,
                        'phoneNumber' =>  $req->phoneNumber,
                        'shortDescription' => $req->shortDescription,
                        'avatar' => $name
                    ]);
                    User::where('id', $id)->update([
                        'name' => $req->displayName
                    ]);
                }
                else if($req->avatar == null){
                    $result = $req->file('avatar')->storeOnCloudinary('avatarchatproject');
                    $name = $result->getFileName();
                     Profile::where('user_id', $id)->update([
                        'user_id' => $id,
                        'displayName' => $req->displayName,
                        'address' => $req->address,
                        'country' => $req->country,
                        'phoneNumber' =>  $req->phoneNumber,
                        'shortDescription' => $req->shortDescription,
                        'avatar' => $name
                    ]);
                    User::where('id', $id)->update([
                        'name' => $req->displayName
                    ]);
                
                }
            }

            Profile::where('user_id', $id)->update([
                'user_id' => $id,
                'displayName' => $req->displayName,
                'address' => $req->address,
                'country' => $req->country,
                'phoneNumber' =>  $req->phoneNumber,
                'shortDescription' => $req->shortDescription
            ]);
            User::where('id', $id)->update([
                'name' => $req->displayName
            ]);
            
        }
        else{
            if($req->avatar){
      
                $result = $req->file('avatar')->storeOnCloudinary('avatarchatproject');
                $name = $result->getFileName();
                    Profile::create([
                        'user_id' => $id,
                        'displayName' => $req->displayName,
                        'address' => $req->address,
                        'country' => $req->country,
                        'phoneNumber' =>  $req->phoneNumber,
                        'shortDescription' => $req->shortDescription,
                        'avatar' => $name
                    ]);
                    User::where('id', $id)->update([
                        'name' => $req->displayName
                    ]);
            }
            else{
                Profile::create([
                    'user_id' => $id,
                    'displayName' => $req->displayName,
                    'address' => $req->address,
                    'country' => $req->country,
                    'phoneNumber' =>  $req->phoneNumber,
                    'shortDescription' => $req->shortDescription
                ]);
                User::where('id', $id)->update([
                    'name' => $req->displayName
                ]);
            }
        }

       
        
    }
}
