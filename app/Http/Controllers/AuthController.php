<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:255|unique:users,username',
            'whatsapp' => 'required|string|regex:/^[1-9][0-9]*$/|unique:users,whatsapp',
            'nik' => 'required|digits:16|unique:users,nik',
            'ttl' => 'required|date',
            'pendidikan' => 'required|string|max:255',
            'jenis_pekerjaan' => 'required|string|max:255',
            'penghasilan' => 'required|numeric|min:0',
            'gender' => 'required|in:Pria,Wanita',
            'password' => 'required|string|min:8|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file foto
        ]);

        // Handle file upload
        $fotoPath = null; // Default null jika tidak ada foto yang diunggah
        if ($request->hasFile('foto')) {
            // Generate UUID untuk nama file
            $uuid = (string) Str::uuid();
            // Ambil ekstensi file asli
            $extension = $request->file('foto')->getClientOriginalExtension();
            // Simpan file dengan nama UUID dan ekstensi asli
            $fotoPath = $request->file('foto')->storeAs('users/foto', $uuid . '.' . $extension, 'public');
        }

        // Simpan ke database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'whatsapp' => '+62' . $request->whatsapp,
            'nik' => $request->nik,
            'ttl' => $request->ttl,
            'pendidikan' => $request->pendidikan,
            'jenis_pekerjaan' => $request->jenis_pekerjaan,
            'penghasilan' => $request->penghasilan,
            'gender' => $request->gender,
            'password' => Hash::make($request->password),
            'foto' => $fotoPath,
            'role' => 'user', // Role default
        ]);

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }


    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email_or_username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Ambil input dari form
        $credentials = $request->only('email_or_username', 'password');
        $remember = $request->has('remember'); // Cek apakah "remember me" dicentang

        // Cek jika yang dimasukkan adalah email atau username
        if (filter_var($credentials['email_or_username'], FILTER_VALIDATE_EMAIL)) {
            // Jika email
            $user = User::where('email', $credentials['email_or_username'])->first();
        } else {
            // Jika username
            $user = User::where('username', $credentials['email_or_username'])->first();
        }

        // Jika user ditemukan dan password cocok
        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Login dan ingatkan sesi berdasarkan pilihan remember me
            Auth::login($user, $remember); // $remember akan menyimpan token remember me

            // Arahkan ke halaman dashboard atau halaman lain yang diinginkan
            return redirect()->route('dashboard');
        } else {
            // Login gagal, kembali ke halaman login dengan error
            return back()->with('error', 'Username / Email atau Password Salah');
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
