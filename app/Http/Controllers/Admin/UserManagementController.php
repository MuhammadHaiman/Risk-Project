<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Agency;
use App\Models\Sektor;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $sektorId = $request->query('sektor_id');
        $query = User::with('agency');

        if ($sektorId) {
            $query->whereHas('agency', function ($q) use ($sektorId) {
                $q->where('sektor_id', $sektorId);
            })->orWhere(function ($q) {
                $q->where('role', 'admin')->whereNull('agensi_id');
            });
        }

        $users = $query->paginate(15);
        $sektors = Sektor::all();

        return view('admin.user.index', ['users' => $users, 'sektors' => $sektors, 'selectedSektor' => $sektorId]);
    }

    public function create()
    {
        $agencies = Agency::all();
        return view('admin.user.create', ['agencies' => $agencies]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,agency',
            'agensi_id' => 'nullable|exists:agencies,id'
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);

        User::create($data);
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berjaya didaftarkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $agencies = Agency::all();
        return view('admin.user.edit', ['user' => $user, 'agencies' => $agencies]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,agency',
            'agensi_id' => 'nullable|exists:agencies,id'
        ]);

        $data = $request->all();
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berjaya dikemaskini');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berjaya dipadam');
    }
}
