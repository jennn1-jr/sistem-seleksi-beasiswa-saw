<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManajemenAdminController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->latest()->get();
        return view('admin.manajemen-admin.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.manajemen-admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => 'admin',
        ]);

        return redirect()->route('admin.manajemen-admin.index')
            ->with('success', 'Akun admin berhasil ditambahkan.');
    }

    public function edit(User $manajemenAdmin)
    {
        return view('admin.manajemen-admin.edit', ['admin' => $manajemenAdmin]);
    }

    public function update(Request $request, User $manajemenAdmin)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'username' => 'required|string|unique:users,username,' . $manajemenAdmin->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = ['name' => $request->name, 'username' => $request->username];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $manajemenAdmin->update($data);

        return redirect()->route('admin.manajemen-admin.index')
            ->with('success', 'Data admin berhasil diperbarui.');
    }

    public function destroy(User $manajemenAdmin)
    {
        if ($manajemenAdmin->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }
        $manajemenAdmin->delete();
        return back()->with('success', 'Akun admin berhasil dihapus.');
    }
}
