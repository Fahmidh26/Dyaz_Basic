<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Carbon;

class BankController extends Controller
{
    public function BankView(){
		$banks = Bank::latest()->get();
		return view('admin.Backend.Bank.bank' ,compact('banks'));
	}


     public function BankStore(Request $request){

    	$request->validate([
    		'bank_name' => 'required',
    		'ac_name' => 'required',
            'ano_name' => 'required',
            'branch' => 'required',
    	],[
    		'bank_name.required' => 'Please Enter Bank Name',
            'ac_name.required' => 'Please Enter Account Name',
            'ano_name.required' => 'Please Enter Account Number',
            'branch.required' => 'Please Enter Branch',
    	]);

        if ($request->file('sign_image')) {

        $image = $request->file('sign_image');
    	$name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

    	Image::make($image)->resize(200,200)->save('upload/bank/'.$name_gen);
    	$save_url = 'upload/bank/'.$name_gen;

	    Bank::insert([
		'bank_name' => $request->bank_name,
		'ac_name' => $request->ac_name,
        'ano_name' => $request->ano_name,
        'branch' => $request->branch,
		'sign_image' => $save_url,
		'created_at' => Carbon::now(),   

    	]);

	    $notification = array(
			'message' => 'Bank Inserted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);
     }else{
        Bank::insert([
            'bank_name' => $request->bank_name,
            'ac_name' => $request->ac_name,
            'ano_name' => $request->ano_name,
            'branch' => $request->branch,
			'balance' => $request->balance,
            'created_at' => Carbon::now(),   
            ]);
    
            $notification = array(
                'message' => 'Bank Inserted Without Image Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);
     }
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
}
