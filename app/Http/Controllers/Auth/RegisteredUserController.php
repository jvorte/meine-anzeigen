<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],

            'country' => ['nullable', 'string', 'max:255'], // New field validation
            'city' => ['nullable', 'string', 'max:255'], // New field validation
            'postal_code' => ['nullable', 'string', 'max:255'], // New field validation
            'street_address' => ['nullable', 'string', 'max:255'], // New field validation
            'mobile_phone' => ['nullable', 'string', 'max:255'], // New field validation
            'phone' => ['nullable', 'string', 'max:255'], // New field validation
        ]);

        $profilePhotoPath = null;
        if ($request->hasFile('profile_photo')) {
            // Store the file in a 'profile-photos' directory within storage/app/public
            $profilePhotoPath = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_photo_path' => $profilePhotoPath,
            'country' => $request->country, // New field to be saved
            'city' => $request->city, // New field to be saved
            'postal_code' => $request->postal_code, // New field to be saved
            'street_address' => $request->street_address, // New field to be saved
            'mobile_phone' => $request->mobile_phone, // New field to be saved
            'phone' => $request->phone, // New field to be saved
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
