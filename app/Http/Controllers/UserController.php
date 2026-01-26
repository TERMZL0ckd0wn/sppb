<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('username')->get();

        // Safely attempt to decrypt stored plain_password for each user
        $users->transform(function ($user) {
            $user->decrypted_password = null;
            if (!empty($user->plain_password)) {
                try {
                    $user->decrypted_password = Crypt::decryptString($user->plain_password);
                } catch (\Throwable $e) {
                    $user->decrypted_password = null; // leave null if decryption fails
                }
            }
            return $user;
        });

        return view('admin.user', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users|min:3',
            'password' => 'required|string|min:6',
            'level' => 'required|in:admin,staff',
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'plain_password' => Crypt::encryptString($request->password), // Simpan encrypted password
            'level' => $request->level,
        ]);

        return redirect()->route('user.index')->with('success', 'Pengguna ditambah.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Pengguna dipadam.');
    }
}

