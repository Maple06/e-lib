<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $account = $this->route('account'); // Assume the route parameter is 'account'

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$account->id,
            'profile_photo' => 'nullable|file|mimes:jpg|max:1024', // max 1MB
        ];
    }

    /**
     * Get the validation messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Judul wajib diisi',
            'name.string' => 'Nama harus berupa teks',
            'name.max' => 'Nama maksimal berisi 255 karakter',
            'email' => 'Email wajib diisi',
            'email.string' => 'Email harus berupa teks',
            'email.email' => 'Format email salah',
            'email.max' => 'Email maksimal berisi 255 karakter',
            'email.unique' => 'Email sudah terdaftar',
            'profile_photo.file' => 'Gambar profil harus berupa berkas.',
            'profile_photo.mimes' => 'Gambar profil harus berformat PNG.',
            'profile_photo.max' => 'Gambar profil tidak boleh lebih dari 1MB.',
        ];
    }
}
