<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use App\Mail\Websitemail;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function AdminLogin()
    {
       
        
        return view('admin.login');
    }
     public function AdminDashboard()
    {
         
        return view('admin.index');
    }
    public function AdminLoginSubmit(Request $request)
    {
        $request->validate([
            'email' =>'required|email',
            'password' => 'required',
             ]);

        $check= $request->all();
        $data= [
          'email' => $check['email'],
          'password' => $check['password'],
           ] ;

           if(Auth::guard('admin')->attempt($data))
           {
              return redirect()->route('admin.admin_dashboard')->with('success','Login Successfully');
           }
           else
           {
            return redirect()->route('admin.login')->with('error','Invalid Credentials');
           }
        
    }

    public function AdminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success','Logout Successfully');

    }
    public function Admin_forget_password()
    {
        return view('admin.forget_password');
    }

    public function Admin_password_submit(Request $request)
    {
        $request->validate([
           'email'=> 'required|email'
        ]);

        $admindata=Admin::where('email',$request->email)->first();
         
        if(!$admindata){

            return redirect()->back()->with('error','Email not found');

        }

        $token=Str::random(60);
        $email=$request->email;

        $admindata->token=$token;
        
        $admindata->update();
        
        //$reset_link=url('admin/reset_password');
        $subject="Reset password";
        $message="Please click on below link to reset password..<br>"; 
        $message .="<a href=http://localhost:8000/admin/reset_password/".$token.">Click Here </a>";
          
        \Mail::to($email)->send(new Websitemail($subject,$message));

        return redirect()->back()->with('success','Reset password link send on your email');

    }
    public function Admin_reset_password($token)
    {

       $admin_data=Admin::where('token',$token)->first();
      
        
       if(!$admin_data)
       {
        return redirect()->route('admin.login')->with('error','Invalid Token or Email..');

       }
       return view('admin.reset_password',compact('token'));
    }

   public function Admin_resetpassword_submit(Request $request)
   {
    $request->validate([
       'password' => 'required',
       'password_confirmation' => 'required|same:password',
    ]);
   

    $admindata=Admin::where('token',$request->token)->first();
     $admindata->password=Hash::make($request->password);
     $admindata->token="";
     $admindata->update();

     return redirect()->route('admin.login')->with('success','password reset successfully');
   }

   public function AdminProfile(){
        $id = Auth::guard('admin')->id();
        $profileData = Admin::find($id);

        return view('admin.admin_profile',compact('profileData'));
     }

    
         public function AdminProfileStore(Request $request){
        $id = Auth::guard('admin')->id();
        $data = Admin::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address; 
        $oldPhotoPath = $data->photo;
        if ($request->hasFile('filephoto')) {
           $file = $request->file('filephoto');
           $filename = time().'.'.$file->getClientOriginalExtension();
           $file->move(public_path('upload/admin-images'),$filename);
           $data->photo = $filename;
           if ($oldPhotoPath && $oldPhotoPath !== $filename) {
              $fullPath = public_path('upload/admin-images/'.$oldPhotoPath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
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

    public function AdminProfileChangePassword()
    {
       $id = Auth::guard('admin')->id();
        $profileData = Admin::find($id);

        return view('admin.change_password',compact('profileData')); 
    }

   public function AdminProfileChangePasswordSubmit(Request $request)
   {

       $id = Auth::guard('admin')->id();
        $Data = Admin::find($id);
        
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required'
            
        ]);

        if (!Hash::check($request->old_password,$Data->password)) {
            $notification = array(
                'message' => 'Old Password Does not Match!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }

       
        /// Update the new password 
        $Data->update([
            'password' => Hash::make($request->new_password)
        ]);
                $notification = array(
                'message' => 'Password Change Successfully',
                'alert-type' => 'success'
            );
            return back()->with($notification);
     }
      // End Method 
   }
    

