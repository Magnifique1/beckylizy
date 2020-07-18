<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){

        $categories = DB::select("select c.id,c.name,count(p.id) as pcount from categories c
                                        inner join products p on c.id = p.category_id
                                        inner join variation_location_details vld on p.id = vld.product_id
                                        where c.business_id = 2 and vld.location_id = 3
                                        group by c.id,c.name
                                        order by c.name asc");


        $categories_featured = DB::select("select c.id,c.name,count(p.id) as pcount from categories c
                                        inner join products p on c.id = p.category_id
                                        inner join variation_location_details vld on p.id = vld.product_id
                                        where c.business_id = 2 and vld.location_id = 3
                                        group by c.id,c.name
                                        order by c.name asc limit 5");

        $products = DB::select("SELECT p.image,p.id,p.name,p.business_id,p.sub_unit_ids,p.category_id,c.name as cname,
                                        ROUND((vgp.price_inc_tax/1.14),2) as price_exc_tax,vgp.price_inc_tax,vld.qty_available
                                        FROM products p
                                        inner join variations v on p.id = v.product_id
                                        inner join variation_group_prices vgp on v.id = vgp.variation_id
                                        inner join variation_location_details vld on p.id = vld.product_id and v.id = vld.variation_id
                                        inner join categories c on p.category_id = c.id
                                        where vld.location_id = 3
                                        order by p.name asc");

        return view('home',[
            'categories'=>$categories,
            'products'=>$products,
            'categories_featured' => $categories_featured
        ]);
    }
}
