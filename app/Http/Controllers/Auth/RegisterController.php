<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Keluarga;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $keluargas = Keluarga::all();
        return view('auth.register', compact('keluargas'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'id_keluarga' => ['nullable', 'exists:keluargas,id'],
            'hubungan' => ['nullable', 'string', 'max:255'],
            'tgl_lahir' => ['nullable', 'date'],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'role' => ['required', 'string', 'in:Anggota,Admin'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        // Memeriksa jika id_keluarga kosong, maka buat keluarga baru
        if (empty($data['id_keluarga'])) {
            $family = Keluarga::create([
                'nama_keluarga' => $data['name'] . "'s Family", // Atur nama keluarga berdasarkan nama pengguna
            ]);
            $data['id_keluarga'] = $family->id;
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'id_keluarga' => $data['id_keluarga'],
            'hubungan' => $data['hubungan'],
            'tgl_lahir' => $data['tgl_lahir'],
            'no_telp' => $data['no_telp'],
            'role' => $data['role'],
        ]);
    }
}
