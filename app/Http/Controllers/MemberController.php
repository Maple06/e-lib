<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the members.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = Member::all();

        return view('pages.members.index', compact('members'));
    }

    /**
     * Show the form for creating a new member.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.members.create');
    }

    /**
     * Store a newly created member in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|min:10|max:13|regex:/^[0-9]+$/|unique:members,phone',
            'email' => 'required|string|email|max:255',
            'type' => 'required',
        ], [
            'full_name.required' => 'Nama lengkap wajib diisi',
            'full_name.string' => 'Nama lengkap harus berupa teks',
            'full_name.max' => 'Nama lengkap maksimal 255 karakter',
            'address.required' => 'Alamat wajib diisi',
            'address.string' => 'Alamat harus berupa teks',
            'address.max' => 'Alamat maksimal 255 karakter',
            'phone.required' => 'Telepon wajib diisi',
            'phone.min' => 'Telepon maksimal 10 karakter',
            'phone.max' => 'Telepon maksimal 13 karakter',
            'phone.regex' => 'Telepon harus berupa nomor',
            'phone.unique' => 'Nomor telepon sudah terdaftar',
            'email.required' => 'Email wajib diisi',
            'email.string' => 'Email harus berupa teks',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email maksimal 255 karakter',
            'type.required' => 'Tipe anggota wajib diisi',
        ]);

        Member::create($request->all());

        return redirect()->route('members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    /**
     * Display the specified member.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        return view('pages.members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified member.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        return view('pages.members.edit', compact('member'));
    }

    /**
     * Update the specified member in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|min:10|max:13|regex:/^[0-9]+$/|unique:members,phone,'.$member->id,
            'email' => 'required|string|email|max:255',
        ], [
            'full_name.required' => 'Nama lengkap wajib diisi',
            'full_name.string' => 'Nama lengkap harus berupa teks',
            'full_name.max' => 'Nama lengkap maksimal 255 karakter',
            'address.required' => 'Alamat wajib diisi',
            'address.string' => 'Alamat harus berupa teks',
            'address.max' => 'Alamat maksimal 255 karakter',
            'phone.required' => 'Telepon wajib diisi',
            'phone.min' => 'Telepon maksimal 10 karakter',
            'phone.max' => 'Telepon maksimal 13 karakter',
            'phone.regex' => 'Telepon harus berupa nomor',
            'phone.unique' => 'Nomor telepon sudah terdaftar',
            'email.required' => 'Email wajib diisi',
            'email.string' => 'Email harus berupa teks',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email maksimal 255 karakter',
        ]);

        $member->update($request->all());

        return redirect()->route('members.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    /**
     * Remove the specified member from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
    }
}
