<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class OrderHistoryProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function cashOnDelivery(Request $request){
        try{

           DB::table('transactions')->where('id',$request->get('OID'))->update([
               'additional_notes' => 'Cash On Delivery'
           ]);

        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        return redirect()->route('order_history')->with('success', 'Order was successfully updated to Cash On Delivery.');

    }

    public function index($o_id){

        $categories = CategoryProductsController::getCategories();

        $orderProducts = DB::select("select tsl.transaction_id, p.name,tsl.quantity,tsl.unit_price_inc_tax,
                                                (tsl.quantity * tsl.unit_price_inc_tax) as subtotal,
                                                t.staff_note from transaction_sell_lines tsl
                                                inner join products p on tsl.product_id = p.id
                                                inner join transactions t on tsl.transaction_id = t.id
                                                where tsl.transaction_id = $o_id");

        $orderPayments = DB::select("select transaction_id, amount,IF(method = 'custom_pay_2', 'M-Pesa', method),transaction_no
                                            from transaction_payments where transaction_id = $o_id");

        $payDetails = DB::select("select additional_notes,staff_note, final_total,
                                        IF((select sum(amount) from transaction_payments where transaction_id = $o_id) is null, 0 ,
                                        (select sum(amount) from transaction_payments where transaction_id = $o_id)) as paid,
                                        shipping_charges,
                                        IF(payment_status = 'paid', final_total,(final_total+shipping_charges)) as Total
                                        from transactions where id = $o_id");

        $payType = DB::select("select additional_notes from transactions where id = $o_id");



        return view('orderproducts',[
            'orderProducts'=>$orderProducts,
            'categories'=>$categories,
            'payDetails'=>$payDetails,
            'orderPayments'=>$orderPayments,
            'orderID'=>$o_id,
            'payType' => $payType
        ]);

    }
}
