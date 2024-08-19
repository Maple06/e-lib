<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAppRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Propaganistas\LaravelPhone\PhoneNumber;

class AppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $app = json_decode(File::get(base_path('app_info.json')));

        return view('pages.app.index', compact('app'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $app = json_decode(File::get(base_path('app_info.json')));

        $phone_formatted = new PhoneNumber($app->socials->phone, 'ID');
        $app->socials->phone = $phone_formatted->formatNational();

        return view('pages.app.edit', compact('app'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAppRequest $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validated();

        // Handle file upload
        if ($request->hasFile('logo_path')) {
            // Delete the old cover image if it exists
            if ($app->logo_path && Storage::disk('public')->exists('image/app-logo.png')) {
                Storage::disk('public')->delete('image/app-logo.png');
            }

            // Store the new file and get the path
            $path = $request->file('logo_path')->storeAs('image', 'app-logo.png', 'public');

            // Save the path to the validated data
            $validatedData['logo_path'] = $path;
        } else {
            // If no new file is uploaded, keep the old cover image
            unset($validatedData['logo_path']);
        }

        // Load the JSON file from the root directory
        $jsonFilePath = base_path('app_info.json');
        if (file_exists($jsonFilePath)) {
            $appInfo = json_decode(file_get_contents($jsonFilePath), true);
        } else {
            $appInfo = [];
        }

        // Update the JSON data with validated data
        $appInfo['name'] = $validatedData['name'] ?? $appInfo['name'];
        $appInfo['description'] = $validatedData['description'] ?? $appInfo['description'];
        $appInfo['logo_path'] = $validatedData['logo_path'] ?? $appInfo['logo_path'];

        $phone_formatted = new PhoneNumber($validatedData['phone'], 'ID');
        $validatedData['phone'] = $phone_formatted->formatNational();

        // Update socials in a loop
        $socialFields = ['facebook', 'instagram', 'linkedin', 'twitter', 'youtube'];

        foreach ($socialFields as $field) {
            // Convert social media links to usernames if necessary
            if (isset($validatedData[$field])) {
                $validatedData[$field] = $this->convertToUsername($validatedData[$field], $field);
            } else {
                // Ensure that the field is cleared if not present in the request
                $validatedData[$field] = '';
            }
            $appInfo['socials'][$field] = $validatedData[$field] ?? $appInfo['socials'][$field];
        }

        // Update email and phone fields
        $appInfo['socials']['email'] = $validatedData['email'] ?? $appInfo['socials']['email'];
        $appInfo['socials']['phone'] = $validatedData['phone'] ?? $appInfo['socials']['phone'];

        // Save the updated JSON back to the file
        file_put_contents($jsonFilePath, json_encode($appInfo, JSON_PRETTY_PRINT));

        return redirect()->route('app.index')->with('success', 'Aplikasi berhasil diperbarui.');
    }

    /**
     * Convert URL to username if necessary.
     *
     * @param string $input
     * @param string $platform
     *
     * @return string
     */
    protected function convertToUsername($input, $platform)
    {
        if (empty($input)) {
            return '';
        }

        // Define regex patterns for each platform
        $patterns = [
            'facebook' => '/(?:https?:\/\/)?(?:www\.)?facebook\.com\/(?:profile\.php\?id=|[a-zA-Z0-9._-]+\/|)([a-zA-Z0-9._-]+)/i',
            'instagram' => '/(?:https?:\/\/)?(?:www\.)?instagram\.com\/([a-zA-Z0-9._-]+)/i',
            'linkedin' => '/(?:https?:\/\/)?(?:www\.)?linkedin\.com\/in\/([a-zA-Z0-9_-]+)/i',
            'twitter' => '/(?:https?:\/\/)?(?:www\.)?(?:x\.com|twitter\.com)\/(?:[a-zA-Z0-9_]+\/)?([a-zA-Z0-9_]+)/i',
            'youtube' => '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:channel\/|user\/|c\/)|youtu\.be\/|youtube\.com\/watch\?v=)([a-zA-Z0-9_-]+)/i',
        ];

        // Extract username based on the platform
        if (isset($patterns[$platform])) {
            preg_match($patterns[$platform], $input, $matches);

            return $matches[1] ?? $input;
        }

        return $input;
    }
}
