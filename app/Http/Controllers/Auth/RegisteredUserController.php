<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Modules\AccountHeads\Models\AccountHead;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' =>['required','string','unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
       

        Auth::login($user);
        AccountHead::insert([
            [
                'name' => 'Cash',
                'slug' => Str::slug('Cash'),
                'user_id' => Auth::id(),
                'created_at' =>Carbon::now(),
               'updated_at' =>Carbon::now()
            ],
            [
                'name' => 'Bank',
                'slug' => Str::slug('Bank'),
                'user_id' => Auth::id(),
                'created_at' =>Carbon::now(),
                'updated_at' =>Carbon::now()
            ],
        ]);

        return redirect(route('transactions.index', absolute: false));
    }
}
