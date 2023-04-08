<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function BankView(){
		$banks = Bank::latest()->get();
		return view('admin.Backend.Bank.bank' ,compact('banks'));
	}

    public function BankCiew(){
		$banks = Bank::latest()->get();
		return view('admin.Backend.Bank.bank' ,compact('banks'));
	}
}
