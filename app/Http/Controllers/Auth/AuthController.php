<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\CategoryProductsController;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
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
                'password' => Hash::make($request->input('password')),
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

        // Login the user using their id
        auth()->loginUsingId($id);

        return redirect()->route('home')->with('success', 'Account was created successfully.');
    }

    public function showLoginForm()
    {
        $categories = CategoryProductsController::getCategories();

        return \view('auth.login', compact('categories'));
    }

    private function failedAuthException()
    {
        throw ValidationException::withMessages([
            'phone_number' => 'Invalid phone number or password.'
        ]);
    }

    public function login(LoginRequest $request)
    {
        // Check if the user exists
        $user = DB::table('contacts')->where('mobile', $request->input('phone_number'))->first();

        if (!$user) {
            return $this->failedAuthException();
        }
        // Attempt to compare the passwords
        if (!Hash::check($request->input('password'), $user->password)) {
            return $this->failedAuthException();
        }

        // Login the user using their id
        auth()->loginUsingId($user->id);

        return redirect()->route('home');
    }

    public function logout()
    {
        //return auth()->user();
        auth()->logout();
        session()->flush();
        return redirect()->route('home');
    }
}
