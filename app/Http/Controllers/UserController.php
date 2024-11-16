<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 

class UserController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }

    

    public function userprofilestore(Request $request)
    {
           $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address; 
        $oldPhotoPath = $data->photo;
        if ($request->hasFile('photo')) {
           $file = $request->file('photo');
           $filename = time().'.'.$file->getClientOriginalExtension();
           $file->move(public_path('upload/user_images'),$filename);
           $data->photo = $filename;
           if ($oldPhotoPath && $oldPhotoPath !== $filename) {
             $this->deleteOldImage($oldPhotoPath);
           }
        }
        $data->save();
        $notification = array(
            'message' => 'Profile Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
     // End Method 
     private function deleteOldImage(string $oldPhotoPath): void {
        $fullPath = public_path('upload/user_images/'.$oldPhotoPath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
     }

  public function UserLogout()
  {
     Auth::guard('web')->logout();
     return redirect('login')->with('success','Logout successfully');
  }

  public function ChangePassword()
  {
    return view('frontend.dashboard.change_password');
  }

  public function ChangePasswordSubmit(Request $request)
  {

    $user=Auth::guard('web')->user();
       $request->validate([
           'old_password'=>'required',
           'password' => 'required',
           
       ]);
        
        
         
        if(!Hash::check($request->old_password,$user->password) )
        {
            $notification = array(
            'message' => 'old password does not match',
            'alert-type' => 'error'
        );
            return back()->with($notification);
        }
       
           User::whereId($user->id)->update(['password'=>Hash::make($request->password)]);
        
       
        $notification = array(
            'message' => 'password changed successfully..',
            'alert-type' => 'success'
         );
       return back()->with($notification);

  }

    }

