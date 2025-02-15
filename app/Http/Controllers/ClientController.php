<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function ClientLogin()
    {
        return view('client.client_login');
    }

    public function ClientRegister()
    {
        return view('client.client_register');
    }

    public function ClientRegisterSubmit(Request $request)
    {
       $request->validate([
            'name' => ['required','string','max:200'],
            'email' => ['required','string','unique:clients'],
            'phone' => ['required','digits:10','starts_with:7,8,9']
        ]);
        Client::insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => 'client',
            'status' => '0', 
        ]);
        $notification = array(
            'message' => 'Client Register Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('client.client_login')->with($notification);
    }

    public function ClientLoginSubmit(Request $request)
    {
       $request->validate([
            
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $check = $request->all();
        $data = [
            'email' => $check['email'],
            'password' => $check['password'],
        ];

        if (Auth::guard('client')->attempt($data)) {
            return redirect()->route('client.client_dashboard')->with('success','Login Successfully');
        }else{
            return redirect()->route('client.client_login')->with('error','Invalid Creadentials');
        }
    }
// End Method 

  public function ClientDashboard()
  {
    return view('client.index');
  }

  public function ClientLogout()
  {
           
               Auth::guard('client')->logout();
               return redirect()->route('client.client_login')->with('success','Logout Successfully');
           
    }

      public function ClientProfile(){
        $id = Auth::guard('client')->id();
        $profileData = Client::find($id);
        return view('client.client_profile',compact('profileData'));
     }

     public function ClientProfileStore(Request $request)
     {
        $id = Auth::guard('client')->id();
        $data = Client::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address; 
        $oldPhotoPath = $data->photo;
        if ($request->hasFile('photo')) {
           $file = $request->file('photo');
           $filename = time().'.'.$file->getClientOriginalExtension();
           $file->move(public_path('upload/client_images'),$filename);
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
     }
    
  

    
    

