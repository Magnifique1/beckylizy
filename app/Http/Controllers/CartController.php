<?php

namespace App\Http\Controllers;

use Cart;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * @var int
     */
    private $deliveryFees;

    public function __construct()
    {
        $this->deliveryFees = 150;
    }

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


        // Get the cart subtotal
        $subtotal = collect(Cart::content())->sum(function ($content) {
            return $content->price * $content->qty;
        });

        $total = $subtotal;
        $deliveryFees = $this->deliveryFees;

        // Check if the total is within the range free delivery range
        if ($subtotal < 3000) {
            $total = $subtotal + 150;
        } else {
            $deliveryFees = 0;
        }

        return view('cart.index', compact(
            'categories', 'contents', 'subtotal', 'deliveryFees', 'total'
        ));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
//        return $request;
        // Extract the request data
        $productID = $request->get('_id');
        $productImage = $request->get('_pimage');
        $productName = $request->get('_pname');
        $quantity = $request->get('_pqty');
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

    public function createOrder(Request $request)
    {
        $user = $request->user();

        $cart = Cart::content();

        $total = collect($cart)->sum(function ($item) {
            return $item->qty * $item->price;
        });

        $taxAmount = $total - ($total / 1.14);

        try {
            $transactionCode = Str::random(6);

            $transactionID = DB::table('transactions')->insertGetId([
                'business_id' => 2,
                'location_id' => 3,
                'type' => 'sell',
                'status' => 'draft',
                'is_quotation' => false,
                'payment_status' => 'due',
                'contact_id' => $user->id,
                'invoice_no' => $transactionCode,
                'transaction_date' => now(),
                'total_before_tax' => $total / 1.14,
                'tax_id' => 2,
                'tax_amount' => $taxAmount,
                'discount_type' => 'percentage',
                'staff_note' => $transactionCode,
                'additional_notes' => 'M-Pesa PayBill',
                'final_total' => $total,
                'is_direct_sale' => false,
                'is_suspend' => false,
                'exchange_rate' => 1,
                'shipping_charges' => $total < 3000 ? $this->deliveryFees : 0,
                'created_by' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            collect($cart)->each(function ($item) use ($transactionID) {
                $price = $item->price;
                DB::table('transaction_sell_lines')->insert([
                    'transaction_id' => $transactionID,
                    'product_id' => $item->id,
                    'variation_id' => $item->id,
                    'quantity' => $item->qty,
                    'unit_price_before_discount' => $price,
                    'unit_price' => $price / 1.14,
                    'line_discount_type' => 'fixed',
                    'unit_price_inc_tax' => $price,
                    'item_tax' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });

            Cart::destroy();

        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        return redirect()->route('order_history')->with('success', 'Order was created successfully.');
    }
}
