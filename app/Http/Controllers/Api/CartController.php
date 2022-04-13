<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class CartController extends Controller
{
    public function AddToCart(Request $request,$id){

        $product = DB::table('products')->where('id',$id)->first();

        $check = DB::table('pos')->where('pro_id',$id)->first();

        if($check){

               DB::table('pos')->where('pro_id',$id)->increment('pro_quantity');

               $product = DB::table('pos')->where('pro_id',$id)->first();
               $subtotal = $product->pro_quantity * $product->product_price;
               DB::table('pos')->where('pro_id',$id)->update(['sub_total'=>$subtotal]);

        }else{

            $data = array();

            $data['pro_id'] = $id;
            $data['pro_name'] = $product->product_name;
            $data['pro_quantity'] = 1;
            $data['product_price'] = $product->selling_price;
            $data['sub_total'] = $product->selling_price;
            $data['created_at'] = NOW();
            $data['updated_at'] = NOW();

            DB::table('pos')->insert($data);
        }

        
    }


    public function allcartitems(){

        $allcartitems = DB::table('pos')->get();

        // $allcartitems = DB::table('pos')

        //               ->join('products','pos.pro_id','products.id')
        //               ->select('pos.pro_id','pro_name','pro_quantity','product_price','sub_total','products.*')->get();

        return response()->json($allcartitems);
    }


    public function removecartitem($id){

        $cartitem = DB::table('pos')->where('id',$id)->delete();
    }

    public function increment($id){

        //check

          $mypos_product = DB::table('pos')->where('id',$id)->first();

          $myproduct = DB::table('products')->where('id',$mypos_product->pro_id)->first();

         if($myproduct->product_quantity == $mypos_product->pro_quantity){

               
         }
         else{
             
             $quantity = DB::table('pos')->where('id',$id)->increment('pro_quantity');
         $product = DB::table('pos')->where('id',$id)->first();
         $subtotal = $product->pro_quantity * $product->product_price;
         DB::table('pos')->where('id',$id)->update(['sub_total'=>$subtotal]);

         }


         

         
    }


    public function decrement($id){

         $quantity = DB::table('pos')->where('id',$id)->decrement('pro_quantity');
         $product = DB::table('pos')->where('id',$id)->first();
         $subtotal = $product->pro_quantity * $product->product_price;
         DB::table('pos')->where('id',$id)->update(['sub_total'=>$subtotal]);
    }


    public function Vats(){

        $vat = DB::table('extra')->first();

        return response()->json($vat);
    }
}
