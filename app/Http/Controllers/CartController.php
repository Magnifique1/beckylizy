<?php

namespace App\Http\Controllers;

use Cart;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        $categories = CategoryProductsController::getCategories();

        // Get the product in the cart
        $contents = Cart::content();

//        return($contents);

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
        $productImage = $request->get('_pimage');
        $productName = $request->get('_pname');
        $quantity = $request->get('_pqty');

        // Get the product data from the DB

        $price = $request->get('_pprice');


        // Add the product to the cart
        Cart::add($productID, sprintf('%s', $productName), $quantity, $price, [
            'image' => $productImage
        ]);

        return redirect()->back()->with('success', 'Product was added successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        $products = array_combine($request->get('rowIds'), $request->get('quantities'));

        foreach ($products as $key => $product) {
            // Update the product quantity
            Cart::update($key, (int)$product);
        }

        return redirect()->back()->with('success', 'Cart has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id)
    {
        if (Cart::get($id)) {
            Cart::remove($id);
        }

        return redirect()->back()->with('success', 'Product was removed successfully.');
    }
}
