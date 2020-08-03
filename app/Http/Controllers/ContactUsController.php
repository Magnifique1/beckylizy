<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index(){

        $categories = CategoryProductsController::getCategories();


        return view('contactus',[
            'categories'=>$categories,
        ]);
    }
}
