<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\CategoryProductsController;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Render the form to be used to register the user
     * @return Application|Factory|View
     */
    public function showRegisterForm()
    {
        $categories = CategoryProductsController::getCategories();

        // Get the delivery regions
        $regions = collect(json_decode(file_get_contents(base_path('storage/json/regions.json'))));

        return view('auth.register', compact('categories', 'regions'));
    }

    /**
     * Create a new account for the user
     * @param RegisterRequest $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function register(RegisterRequest $request)
    {
        try {
            $id = DB::table('contacts')->insertGetId([
                'business_id' => 2,
                'type' => 'customer',
                'name' => ucwords(strtolower($request->input('name'))),
                'password' => bcrypt($request->input('password')),
                'contact_id' => 'ECOM1234',
                'contact_status' => 'active',
                'mobile' => $request->input('phone_number'),
                'city' => 'Nairobi',
                'state' => $request->input('region'),
                'country' => 'Kenya',
                'landmark' => $request->input('region'),
                'created_by' => 2,
                'total_rp' => 0,
                'total_rp_used' => 0,
                'total_rp_expired' => 0,
                'is_default' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('contacts')->where('id', $id)->update([
                'contact_id' => sprintf("ECOM%03d", $id),
            ]);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        return redirect()->back()->with('success', 'Account was created successfully.');
    }
}
