<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryProductsController extends Controller
{
    public function index($id){
        $categories = DB::select("select c.id,c.name,count(p.id) as pcount from categories c
                                        inner join products p on c.id = p.category_id
                                        inner join variation_location_details vld on p.id = vld.product_id
                                        where c.business_id = 2 and vld.location_id = 3
                                        group by c.id,c.name
                                        order by c.name asc");

        $selected_cat = DB::select("select name from categories where id = $id");

        $products = DB::select("SELECT p.image,p.id,p.name,p.business_id,p.sub_unit_ids,p.category_id,c.name as cname,
                                        ROUND((vgp.price_inc_tax/1.14),2) as price_exc_tax,vgp.price_inc_tax,vld.qty_available
                                        FROM products p
                                        inner join variations v on p.id = v.product_id
                                        inner join variation_group_prices vgp on v.id = vgp.variation_id
                                        inner join variation_location_details vld on p.id = vld.product_id and v.id = vld.variation_id
                                        inner join categories c on p.category_id = c.id
                                        where vld.location_id = 3 and p.category_id = $id
                                        order by p.name asc");

        return view('products',[
            'categories'=>$categories,
            'products'=>$products,
            'selected_cat'=>$selected_cat
        ]);
    }
}
