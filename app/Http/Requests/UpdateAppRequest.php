<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $app = $this->route('app'); // Assume the route parameter is 'app'

        return [
            'name' => 'required|string|max:15',
            'description' => 'required|string',
            'logo_path' => 'nullable|file|mimes:png|max:1024', // max 1MB
            'email' => 'required|string|email|max:255',
            'phone' => 'required|phone:ID',
            'facebook' => ['nullable', 'regex:/^(https?:\/\/(www\.)?facebook\.com\/[a-zA-Z0-9(\.\?)?]+|^[a-zA-Z0-9(\.\?)?]+$)/', 'max:255'],
            'instagram' => ['nullable', 'regex:/^(https?:\/\/(www\.)?instagram\.com\/[a-zA-Z0-9(\.\?)?]+|^[a-zA-Z0-9(\.\?)?]+$)/', 'max:255'],
            'linkedin' => ['nullable', 'regex:/^(https?:\/\/(www\.)?linkedin\.com\/in\/[a-zA-Z0-9(\.\?)?]+|^[a-zA-Z0-9(\.\?)?]+$)/', 'max:255'],
            'twitter' => ['nullable', 'regex:/^(https?:\/\/(www\.)?(twitter\.com|x\.com)\/[a-zA-Z0-9(\.\?)?]+|^[a-zA-Z0-9(\.\?)?]+$)/', 'max:255'],
            'youtube' => ['nullable', 'regex:/^(https?:\/\/(www\.)?youtube\.com\/(user|channel)\/[a-zA-Z0-9(\.\?)?]+|^[a-zA-Z0-9(\.\?)?]+$)/', 'max:255'],
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
            'name.string' => 'Judul harus berupa teks',
            'name.max' => 'Judul maksimal berisi 15 karakter',
            'description.required' => 'Deskripsi wajib diisi',
            'description.string' => 'Deskripsi harus berupa teks',
            'email' => 'Email wajib diisi',
            'email.string' => 'Email harus berupa teks',
            'email.email' => 'Format email salah',
            'email.max' => 'Email maksimal berisi 255 karakter',
            'logo_path.file' => 'Logo aplikasi harus berupa berkas.',
            'logo_path.mimes' => 'Logo aplikasi harus berformat PNG.',
            'logo_path.max' => 'Logo aplikasi tidak boleh lebih dari 1MB.',
            'phone' => 'Nomor telepon wajib diisi',
            'phone.phone' => 'Format nomor telepon salah',
            'facebook.regex' => 'Format URL Facebook salah.',
            'facebook.max' => 'URL Facebook maksimal berisi 255 karakter.',
            'instagram.regex' => 'Format URL Instagram salah.',
            'instagram.max' => 'URL Instagram maksimal berisi 255 karakter.',
            'linkedin.regex' => 'Format URL LinkedIn salah.',
            'linkedin.max' => 'URL LinkedIn maksimal berisi 255 karakter.',
            'twitter.regex' => 'Format URL Twitter atau X salah.',
            'twitter.max' => 'URL Twitter maksimal berisi 255 karakter.',
            'youtube.regex' => 'Format URL YouTube salah.',
            'youtube.max' => 'URL YouTube maksimal berisi 255 karakter.',
        ];
    }
}
