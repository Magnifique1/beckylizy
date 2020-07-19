<?php

namespace App\Http\Controllers;

use Cart;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $categories = DB::select("select c.id,c.name,count(p.id) as pcount from categories c
                                        inner join products p on c.id = p.category_id
                                        inner join variation_location_details vld on p.id = vld.product_id
                                        where c.business_id = 2 and vld.location_id = 3
                                        group by c.id,c.name
                                        order by c.name asc");

        // Get the product in the cart
        $contents = Cart::content();

        // Get the cart subtotal
        $subtotal = Cart::subtotal();

        return view('cart.index', compact('categories', 'contents', 'subtotal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        // Extract the request data
        $productID = $request->get('_id');
        $quantity = $request->get('quantity');

        // Get the product data from the DB

        $price = rand(100, 500);

        // Add the product to the cart
        Cart::add($productID, sprintf('Product %d', $productID), $quantity, $price);

        return redirect()->back()->with('success', 'Product was added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
