<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAccountRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $librarians = User::where('role', 'librarian')
            ->select('id', 'name', 'email', 'created_at')
            ->get();

        return view('pages.users.index', compact('librarians'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*\d)[A-Za-z\d]*$/',
            ],
        ], [
            'full_name.required' => 'Nama lengkap wajib diisi',
            'full_name.string' => 'Nama lengkap harus berupa teks',
            'full_name.max' => 'Nama lengkap maksimal 255 karakter',
            'email.required' => 'Email wajib diisi',
            'email.string' => 'Email harus berupa teks',
            'email.email' => 'Email harus valid',
            'email.max' => 'Email maksimal 255 karakter',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.string' => 'Password harus berupa teks',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password berbeda',
            'password.regex' => 'Password harus mengandung minimal satu angka',
        ]);

        User::create([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'librarian',
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $account)
    {
        if (Auth::id() !== $account->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('pages.account.index', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $account)
    {
        if (Auth::id() !== $account->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('pages.account.edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccountRequest $request, User $account)
    {
        if (Auth::id() !== $account->id) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validated();

        // Handle file upload
        if ($request->hasFile('profile_photo')) {
            // Delete the old cover image if it exists
            if ($account->profile_photo) {
                Storage::disk('public')->delete($account->profile_photo);
            }

            // Store the new file and get the path
            $path = $request->file('profile_photo')->store('profiles', 'public');

            // Save the path to the validated data
            $validatedData['profile_photo'] = $path;
        } else {
            // If no new file is uploaded, keep the old cover image
            unset($validatedData['profile_photo']);
        }

        $account->update($validatedData);

        return redirect()->route('account.show', $account->id)->with('success', 'Akun berhasil diperbarui.');
    }

    /**
     * Update password page.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_password($id)
    {
        $id = (int) $id;

        if (Auth::id() !== $id) {
            abort(403, 'Unauthorized action.');
        }

        $account = Auth::user();

        return view('pages.account.edit_password', compact('account'));
    }

    /**
     * Updates the users password.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request, $id)
    {
        $id = (int) $id;

        if (Auth::id() !== $id) {
            abort(403, 'Unauthorized action.');
        }
        $user = Auth::user();

        // Check if current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah']);
        }

        $request->validate([
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*\d)[A-Za-z\d]*$/',
            ],
        ], [
            'new_password.required' => 'Password baru harus diisi',
            'new_password.string' => 'Password baru harus berupa teks',
            'new_password.min' => 'Password baru minimal 8 karakter',
            'new_password.regex' => 'Password baru harus mengandung minimal satu angka',
        ]);

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('account.show', $user->id)->with('status', 'Password berhasil diganti');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $account)
    {
        $id = (int) $id;

        if (Auth::id() !== $account->id) {
            abort(403, 'Unauthorized action.');
        } elseif (Auth::user()->role == 'admin') {
            abort(403, 'Unauthorized action. Cannot delete admin account.');
        }

        $account->delete();

        return redirect()->route('home.index')->with('success', 'Akun berhasil dihapus');
    }
}
