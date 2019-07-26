<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class SliderController extends Controller
{
    public function index()
    {
    	return view('admin.add_slider');
    }
  public function save_slider(Request $request)
  {
$data=array();

$data['publication_status']=$request->publication_status;
   $image=$request->file('slider_image');
    	if ($image){
    		$image_name=str_random(20);
    		$ext=strtolower($image->getClientOriginalExtension());
    		$image_full_name=$image_name.'.'.$ext;
    		$uplode_path='slider/';
    		$image_url=$uplode_path.$image_full_name;
    		$success=$image->move($uplode_path,$image_full_name);
		if ($success) {
		$data['slider_image']=$image_url;	

		 DB::table('tbl_sliders')->insert($data);
      Session::put('message','slider added successfully');
      return Redirect::to('/add-slider');
		}
    	}
	$data['slider_image']='';
	   DB::table('tbl_sliders')->insert($data);
      Session::put('message','slider added successfully Without Image');
      return Redirect::to('/add-slider');

    }

    public function all_slider()
    {
    	
   
   $all_slider=DB::table('tbl_sliders')->get();
   $manage_slider=view('admin.all_slider')
   ->with('all_slider',$all_slider);
   return view('admin_layout')
   ->with('admin.all_slider',$manage_slider);

    }

        //active
     public function active_slider($slider_id)
    {
    	 DB::table('tbl_sliders')
    	 ->where('slider_id',$slider_id)
    	 ->update(['publication_status' => 1]);
    	   Session::put('message','slider actived successfully');
    	 return Redirect::to('/all-slider');
    }

    //unactive
    public function unactive_slider($slider_id)
    {
    	 DB::table('tbl_sliders')
    	 ->where('slider_id',$slider_id)
    	 ->update(['publication_status' => 0]);
    	   Session::put('message','slider unactive successfully');
    	 return Redirect::to('/all-slider');
    }

    //delete
      public function delete_slider($slider_id)
    {
    	 DB::table('tbl_sliders')
    	 ->where('slider_id',$slider_id)
    	->delete();
    	   Session::put('message','slider deleted successfully');
    	 return Redirect::to('/all-slider');
}

  }


