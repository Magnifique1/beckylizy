<?php

namespace App\Http\Controllers;

use Cart;
use Exception;
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
        Cart::add($productID, sprintf('%s', $productName), $price, $quantity, [
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

    public function createOrder(Request $request)
    {
        // INSERT INTO transactions(business_id,location_id,type,status,is_quotation,payment_status,contact_id,
        //                           transaction_date,total_before_tax,tax_id,tax_amount,discount_type,
        //                           final_total,is_direct_sale,is_suspend,exchange_rate,created_by,
        //                           created_at,updated_at)
        //VALUES (2, 2, 'sell','draft',0,'due',10,CURRENT_TIMESTAMP(),74.5600,2,10.4384,'percentage',
        //        85.0000,0,0,1.000,3,CURRENT_TIMESTAMP(),CURRENT_TIMESTAMP());

        // Get the auth user data
        $user = $request->user();

        $cart = Cart::content();

        $total = collect($cart)->sum(function ($item) {
            return $item->qty * $item->price;
        });

        $taxAmount = $total * 1.14;

        try {
            $transactionID = DB::table('transactions')->insertGetId([
                'business_id' => 2,
                'location_id' => 2,
                'type' => 'sell',
                'status' => 'draft',
                'is_quotation' => false,
                'payment_status' => 'due',
                'contact_id' => $user->id,
                'transaction_date' => now(),
                'total_before_tax' => $total - $taxAmount,
                'tax_id' => 2,
                'tax_amount' => $taxAmount,
                'discount_type' => 'percentage',
                'final_total' => $total,
                'is_direct_sale' => false,
                'is_suspend' => false,
                'exchange_rate' => 1,
                'created_by' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            collect($cart)->each(function ($item) use ($transactionID) {
                // INSERT INTO transaction_sell_lines(transaction_id, product_id, variation_id, quantity,
                //                                    unit_price_before_discount, unit_price,
                //                                     line_discount_type, unit_price_inc_tax,item_tax,
                //                                     created_at, updated_at)
                //VALUES (38,54,54,1.0000,74.5600,74.5600,'fixed',74.5600,0.0000,CURRENT_TIMESTAMP(),CURRENT_TIMESTAMP());

                $price = $item->price;

                DB::table('transaction_sell_lines')->insert([
                    'transaction_id' => $transactionID,
                    'product_id' => $item->id,
                    'variation_id' => $item->id,
                    'quantity' => $item->qty,
                    'unit_price_before_discount' => $price,
                    'unit_price' => $price,
                    'line_discount_type' => 'fixed',
                    'unit_price_inc_tax' => $price,
                    'item_tax' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        return redirect()->back()->with('success', 'Order was created successfully.');
    }
}
