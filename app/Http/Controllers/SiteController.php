<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Site;

class SiteController extends Controller
{
    public function SiteView(){
		$sites = Site::latest()->get();
		return view('admin.Backend.Site.manage_site' ,compact('sites'));
	}
}
