<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catagory;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\City;


class CatagoryController extends Controller
{
    public function AllCatagory()
    {
         $catagory=Catagory::latest()->get();
         return view('admin.catagory.all_catagory',compact('catagory'));

    }

    public function AddCatagory()
    {

        return view ('admin.catagory.add_catagory');
    }

    public function CatagoryStore(Request $request)
    {
        if ($request->file('image')) {
            $image = $request->file('image');
            $name_gen = time().'.'.$image->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            
            $img = $manager->read($image);
            $img->resize(300,300)->save(public_path('upload/category/'.$name_gen));
            $save_url = 'upload/category/'.$name_gen;
            Catagory::create([
                'catagory_name' => $request->category_name,
                'image' => $save_url, 
            ]); 
        } 
        $notification = array(
            'message' => 'Category Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.catagory')->with($notification);
    }

    public function EditCatagory($id)
    {

        $data=Catagory::find($id);
        
        return view('admin.catagory.edit_catagory',compact('data'));
    }

    public function CatagoryUpddate(Request $request)
    {

        $id=$request->id;
        if ($request->file('image')) {
            $image = $request->file('image');
            $name_gen = time().'.'.$image->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            
            $img = $manager->read($image);
            $img->resize(300,300)->save(public_path('upload/category/'.$name_gen));
            $save_url = 'upload/category/'.$name_gen;
            Catagory::find($id)->update([
                'catagory_name' => $request->catagory_name,
                'image' => $save_url, 
            ]); 
         
        $notification = array(
            'message' => 'Category updated Successfully',
            'alert-type' => 'success'
        );
         return redirect()->route('all.catagory')->with($notification);
    }
          else{
          Catagory::find($id)->update([
        'catagory_name' => $request->catagory_name,
    ]);
        $notification = array(
            'message' => 'Category updated Successfully',
            'alert-type' => 'success'
        );

           
           return redirect()->route('all.catagory')->with($notification);
       }
    }

    public function DeleteCatagory($id)
    {
        $data=Catagory::find($id);
        $img=$data->image;
        unlink($img);
        $data->delete();
        $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success'
        );

           
           return redirect()-> back()->with($notification);

    }

    public function AllCity()
    {

         $city=City::latest()->get();
         return view('admin.city.all_city',compact('city'));

    }

    public function CityStore(Request $request)
    {
         City::create([
                'city_name' => $request->city_name,
                 'city-slug' =>  strtolower(str_replace(' ','-',$request->city_name)), 
            ]); 
        
        $notification = array(
            'message' => 'City Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function EditCity($id)
    {
        $city = City::find($id);
        return response()->json($city);
    }

    public function CityUpdate(Request $request)
    {

        $data = $request->cat_id;
       City::find($data)->update([
                'city_name' => $request->city_name,
                 'city-slug' =>  strtolower(str_replace(' ','-',$request->city_name)), 
            ]); 
        
        $notification = array(
            'message' => 'City Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification); 
    }

    public function DeleteCity($id){
      City::find($id)->delete();
      $notification = array(
        'message' => 'City Deleted Successfully',
        'alert-type' => 'success'
    );
    return redirect()->back()->with($notification);
   }
    
}
