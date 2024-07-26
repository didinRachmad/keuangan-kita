<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('Profil', [
            'title' => 'Profil',
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|confirmed'
        ]);

        try {
            $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'] ? Hash::make($validatedData['password']) : $user->password,
            ]);

            // if ($validatedData['password'] || $validatedData['email'] !== $user->getOriginal('email')) {
            //     return redirect()->route('Profil.index')->with('info', 'Profil diperbarui. Silakan login ulang.');
            // }

            return redirect()->route('Profil.index')->with('sukses', 'Profil berhasil diperbarui.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Gagal.', ['exception' => $e]);
            return redirect()->back()->with('gagal', 'profil tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Gagal.', ['exception' => $e]);
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat memperbarui profil.');
        }
    }
}
