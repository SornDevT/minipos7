<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transection;
use App\Models\Bills;
use App\Models\BillsList;
use App\Models\Store;

class TransectionController extends Controller
{
    //

    public function add(Request $request){
        try{


                $bill_id = 1;
                $bills = Bills::all()->sortByDesc('id')->take(1)->toArray();

                foreach($bills as $new){
                    $bill_id = $new["bill_id"];
                }
                // ຕົວຢ່າງ INC00001
                if($bill_id !=''){
                    // $bill_id1 = str_replace("INC","",$bill_id); // 00001
                    // $bill_id2 = str_replace("EXP","",$bill_id1);
                    $bill_id3 = (int)$bill_id+1; // 1+1 = 2
                    $length = 5;
                    $new_bill_id = substr(str_repeat(0,$length).$bill_id3, - $length); //00002
                }

                // ບັນທຶກຂໍ້ມູນໃບບິນ
                $bills = new Bills();
                $bills->bill_id = $new_bill_id; 
                $bills->customer_name = $request->customer_name;
                $bills->customer_tel = $request->customer_tel;
                $bills->save();




            foreach($request->listorder as $item){

                $number = 1;
                $tran = Transection::all()->sortByDesc('id')->take(1)->toArray();

                foreach($tran as $new){
                    $number = $new["tran_id"];
                }
                // ຕົວຢ່າງ INC00001
                if($number !=''){
                    $number1 = str_replace("INC","",$number); // 00001
                    $number2 = str_replace("EXP","",$number1);
                    $number3 = (int)$number2+1; // 1+1 = 2
                    $length = 5;
                    $number = substr(str_repeat(0,$length).$number3, - $length); //00002
                }

                if($request->acc_type == "income") {
                    $tnum = "INC"; //INC
                } elseif($request->acc_type == "expense") {
                    $tnum = "EXP"; // EXP
                }

                $tran = new Transection();
                $tran->tran_id = $tnum.$number; //INC00002
                $tran->product_id = $item['id'];
                $tran->tran_type = $request->acc_type;
                $tran->tran_detail = $item['name'];
                $tran->amount = $item['order_amount'];
                $tran->price = $item['order_amount']*$item['price_sell'];
                $tran->save();

                // ອັບເດດຕັດ ສະຕ໋ອກ
                $store = Store::find($item['id']);

                $store_update = Store::find($item['id']);
                $store_update->update([
                    'amount'=>$store->amount - $item['order_amount'],
                ]);

                // ບັນທຶກລາຍການໃບບິນ
                $bills = new BillsList();
                $bills->bill_id = $new_bill_id; 
                $bills->name = $item['name'];
                $bills->amount = $item['order_amount'];
                $bills->price = $item['price_sell'];
                $bills->save();

            }
      
            

                $success = true;
                $message = "ບັນທຶກຂໍ້ມູນສຳເລັດ!";

    

        } catch (\Illuminate\Database\QueryException $ex){
            $success = false;
            $message = $ex->getMessage();
            $new_bill_id = "";
        }

        $response = [
            "success" => $success,
            "message" => $message,
            "bills_id" => $new_bill_id
        ];

        return response()->json($response);
    }
}
