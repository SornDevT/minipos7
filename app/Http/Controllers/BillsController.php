<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bills;
use App\Models\BillsList;

class BillsController extends Controller
{
    //
    public function print($id){

        $bills = Bills::where('bill_id',$id)->get();
        $bills_list = BillsList::where('bill_id',$id)->get();

        return view('bill')->with('bills',$bills)->with('bills_list',$bills_list)->with('bills_id',$id);
    }
}
