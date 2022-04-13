<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DateTime;

class PosController extends Controller
{
    public function GetProduct($id){

        $product = DB::table('products')->where('category_id',$id)->get();

        return response()->json($product);
    }

    public function OrderDone(Request $request){

        $validateData = $request->validate([
           
             'customer_id' => 'required',
             'payby'       => 'required'

        ]);


        $data = array();

        $data['customer_id'] = $request->customer_id;
        $data['qty'] = $request->qty;
        $data['sub_total'] = $request->subtotal;
        $data['vat'] = $request->vats;
        $data['total'] = $request->total;
        $data['pay'] = $request->pay;
        $data['due'] = $request->due;
        $data['payby'] = $request->payby;
        $data['order_date'] = date('d/m/Y');
        $data['order_month'] = date('F');
        $data['order_year'] = date('Y');
        $order_id = DB::table('orders')->insertGetId($data); 


        $contents = DB::table('pos')->get();

        $odata = array();

        foreach ($contents as $content) {
            
            $odata['order_id'] = $order_id;
            $odata['product_id'] = $content->pro_id;
            $odata['pro_quantity'] = $content->pro_quantity;
            $odata['product_price'] = $content->product_price;
            $odata['sub_total'] = $content->sub_total;

            DB::table('order_details')->insert($odata);

            DB::table('products')->where('id',$content->pro_id)
            ->update(['product_quantity'=> DB::raw('product_quantity -'.$content->pro_quantity)]);
        }

        DB::table('pos')->delete();
    }


    public function Order(){

        $data = date('d/m/Y');

        $orders = DB::table('orders')

             ->join('customers','orders.customer_id','customers.id')
             ->where('order_date',$data)
             ->select('customers.name','orders.*')
             ->orderBy('orders.id','DESC')->get();

             return response()->json($orders);
    }


    public function SearchOrderDate(Request $request){

         $orderdate = $request->date;

         $newdate = new DateTime($orderdate);

         $done = $newdate->format('d/m/Y');

         $order = DB::table('orders')

                ->join('customers','orders.customer_id','customers.id')
                ->select('customers.name','orders.*')
                ->where('orders.order_date',$done)->get();

         return response()->json($order);
    }


    public function todaySale(){

        $date = Date('d/m/Y');

        $sell = DB::table('orders')->where('order_date',$date)->sum('total');

        return response()->json($sell);
    }

     public function todayIncome(){

        $date = Date('d/m/Y');

        $sell = DB::table('orders')->where('order_date',$date)->sum('pay');

        return response()->json($sell);
    }


    public function todayDue(){

        $date = Date('d/m/Y');

        $sell = DB::table('orders')->where('order_date',$date)->sum('due');

        return response()->json($sell);
    }
     

    public function todayProduct(){

      
        $sell = DB::table('products')->where('product_quantity','<','1')->get();

        $thesel = $sell->count();

        return response()->json($thesel);
    } 


    public function stockProduct(){

      
        $sell = DB::table('products')
              ->join('categories','products.category_id','categories.id')
              ->select('categories.category_name','products.*')
              ->where('product_quantity','<','1')->get();

        return response()->json($sell);
    } 

}
