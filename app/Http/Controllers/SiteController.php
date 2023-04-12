<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Site;
use Intervention\Image\Facades\Image as Image;

class SiteController extends Controller
{
    public function SiteView(){
		$sites = Site::latest()->first();
		return view('admin.Backend.Site.manage_site' ,compact('sites'));
	}

	public function SiteSettingUpdate(Request $request){

    	// $site_id = $request->id;

    	if ($request->file('logo')) {

    	$image = $request->file('logo');
    	$name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
    	Image::make($image)->save('upload/logo/'.$name_gen);
    	$save_url_l = 'upload/logo/'.$name_gen;

	Site::findOrFail(1)->update([
		'name' => $request->phone_one,
		'address' => $request->phone_two,
		'email' => $request->email,
		'phone' => $request->company_name,
		'logo' => $save_url_l,

    	]);

	    $notification = array(
			'message' => 'Setting Updated with Logo Successfully',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);

    	}elseif($request->file('watermark')) {

    	$image = $request->file('watermark');
    	$name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
    	Image::make($image)->save('upload/logo/'.$name_gen);
		$save_url_w = 'upload/logo/'.$name_gen;

	Site::findOrFail(1)->update([
		'name' => $request->phone_one,
		'address' => $request->phone_two,
		'email' => $request->email,
		'phone' => $request->company_name,
		'watermark' => $save_url_w,

    	]);

	    $notification = array(
			'message' => 'Setting Updated with Watermark Successfully',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);
    	}
		
		else{

    	Site::findOrFail(1)->update([
		'name' => $request->phone_one,
		'address' => $request->phone_two,
		'email' => $request->email,
		'phone' => $request->company_name,
    	]);

	    $notification = array(
			'message' => 'Setting Updated Successfully',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);

    	} // end else 
    } // end method 

}
