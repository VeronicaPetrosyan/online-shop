<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\CartController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\CartItem;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if (Cookie::has('cart')) {
            $cookieCart = json_decode(Cookie::get('cart'), true);

            foreach ($cookieCart as $item) {
                CartItem::updateOrCreate(
                    ['user_id' => $user->id, 'product_id' => $item['product_id']],
                    ['quantity' => $item['quantity']]
                );
            }

            Cookie::queue(Cookie::forget('cart'));
        }

        return redirect()->intended($this->redirectPath());
    }

}
