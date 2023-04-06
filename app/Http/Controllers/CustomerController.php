<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Dealer;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;

class CustomerController extends Controller
{
    public function CustomerView(){
		$customers = Customer::where('dea_cus',1)->orderBy('customer_name','ASC')->get();
		return view('admin.Backend.Brand.customer' ,compact('customers'));
	}


     public function CustomerStore(Request $request){

    	$request->validate([
    		 
    		'customer_name' => 'required',
    	],[
    		'phone' => 'required',
    		 
    	]);

        Customer::insert([
		'customer_name' => $request->customer_name,
        'email' => $request->email,
        'phone' => $request->phone,
        'address' => $request->address,
		'dea_cus' => 1,
    	]);

	    $notification = array(
			'message' => 'Customer Inserted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

    } // end method

	public function CustomerEdit($id){
		$customer = Customer::findOrFail($id);
			return view('admin.Backend.Brand.Slider.slider_edit',compact('customer'));
		}
	
	
	public function CustomerUpdate(Request $request){
			
			$slider_id = $request->id;
			$old_img = $request->old_image;
	
			if ($request->file('slider_img')) {
	
			unlink($old_img);
			$image = $request->file('slider_img');
			$name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
			Image::make($image)->resize(869,370)->save('upload/slider/'.$name_gen);
			$save_url = 'upload/slider/'.$name_gen;
	
            Customer::findOrFail($slider_id)->update([
			'title' => $request->title,
			// 'description' => $request->description,
			'slider_img' => $save_url,
	
			]);
	
			$notification = array(
				'message' => 'Slider Updated Successfully',
				'alert-type' => 'info'
			);
	
			return redirect()->route('slider.view')->with($notification);
	
			}else{
	
                Customer::findOrFail($slider_id)->update([
			'title' => $request->title,
			// 'description' => $request->description,
			
	
			]);
	
			$notification = array(
				'message' => 'Slider Updated Without Image Successfully',
				'alert-type' => 'info'
			);
	
			return redirect()->route('slider.view')->with($notification);
	
			} // end else 
		} // end method 
	
	
		public function CustomerDelete($id){
			$customer = Customer::findOrFail($id);
			$img = $customer->slider_img;
			unlink($img);
			Customer::findOrFail($id)->delete();
	
			$notification = array(
				'message' => 'Slider Delectd Successfully',
				'alert-type' => 'info'
			);
	
			return redirect()->back()->with($notification);
	
		} // end method

		public function DealerView(){
			$dealers = Dealer::latest()->get();
			return view('admin.Backend.Dealer.dealer' ,compact('dealers'));
		}
	
}
