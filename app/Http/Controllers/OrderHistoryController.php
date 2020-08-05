<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderHistoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $userID = auth()->id();
        $categories = CategoryProductsController::getCategories();

        $orders = DB::select("select t.id,t.transaction_date,t.status, t.payment_status, t.invoice_no,t.staff_note,
                                    t.additional_notes, t.total_before_tax,t.tax_amount,t.final_total
                                    from transactions t
                                    where t.contact_id = $userID order by t.transaction_date desc");

        return view('orderhistory',[
            'orders'=>$orders,
            'categories'=>$categories,
        ]);

    }
    //
}
