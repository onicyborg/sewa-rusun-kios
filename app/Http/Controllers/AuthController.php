<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

    public function update(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|numeric',
            'username' => 'required|string|max:255',
            'nik' => 'nullable|string|max:255',
            'ttl' => 'nullable|date',
            'pendidikan' => 'nullable|string|max:255',
            'jenis_pekerjaan' => 'nullable|string|max:255',
            'penghasilan' => 'nullable|numeric',
            'gender' => 'nullable|in:Pria,Wanita',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = User::find(Auth::id());

        // Update data yang wajib
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->whatsapp = '+62' . ltrim($validated['whatsapp'], '0');
        $user->username = $validated['username'];

        // Update data opsional
        $user->nik = $request->nik;
        $user->ttl = $request->ttl;
        $user->pendidikan = $request->pendidikan;
        $user->jenis_pekerjaan = $request->jenis_pekerjaan;
        $user->penghasilan = $request->penghasilan;
        $user->gender = $request->gender;

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto) {
                Storage::delete($user->foto);
            }

            // Simpan foto baru
            $uuid = (string) Str::uuid();
            // Ambil ekstensi file asli
            $extension = $request->file('foto')->getClientOriginalExtension();
            // Simpan file dengan nama UUID dan ekstensi asli
            $fotoPath = $request->file('foto')->storeAs('users/foto', $uuid . '.' . $extension, 'public');

            $user->foto = $fotoPath;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function changePassword(Request $request)
    {
        // Validasi input
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = User::find(Auth::id());

        // Cek apakah password saat ini benar
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diperbarui.');
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

    public function profile()
    {
        if (Auth::user()->role == 'admin') {
            return view('admin.profile-admin');
        } else {
            return view('users.profile-user');
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
