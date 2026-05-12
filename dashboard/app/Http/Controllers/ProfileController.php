<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        
        // Tentukan view berdasarkan role user
        switch ($user->role) {
            case 'mentor':
                return view('mentor.profile', compact('user'));
            case 'student':
                return view('user.profile', compact('user'));
            case 'admin':
            default:
                return view('admin.profile', compact('user'));
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi dasar untuk semua role
        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|min:6|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        // Hanya tambahkan validasi untuk field yang ada di database
        if ($user->role === 'student') {
            // Cek dulu apakah kolom ini ada di database sebelum validasi
            $validationRules['school'] = 'nullable|string|max:255';
            $validationRules['city'] = 'nullable|string|max:100';
            $validationRules['hobby'] = 'nullable|string|max:255';
        }

        $request->validate($validationRules);

        // Update data profile dasar (field yang pasti ada)
        $user->name = $request->name;
        $user->email = $request->email;
        $user->date_of_birth = $request->date_of_birth;
        $user->gender = $request->gender;
        $user->phone = $request->phone;

        // Update field tambahan hanya jika kolomnya ada di database
        if ($user->role === 'student') {
            // Gunakan null coalescing untuk menghindari error jika field tidak ada
            $user->school = $request->school ?? $user->school;
            $user->city = $request->city ?? $user->city;
        }

        // HINDARI update field yang tidak ada di database untuk mentor
        // if ($user->role === 'mentor') {
        //     // Jangan update specialization dan bio karena kolom tidak ada
        //     // $user->specialization = $request->specialization; // Kolom tidak ada
        //     // $user->bio = $request->bio; // Kolom tidak ada
        // }

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }


    // Upload foto jika ada - DENGAN DEBUG
    if ($request->hasFile('profile_photo')) {
        \Log::info('Profile photo upload started for user: ' . $user->id);
        
        // Hapus foto lama jika ada
        if ($user->profile_photo) {
            \Log::info('Deleting old photo: ' . $user->profile_photo);
            
            // Hapus dari public disk
            if (Storage::disk('public')->exists('profile_photos/' . $user->profile_photo)) {
                Storage::disk('public')->delete('profile_photos/' . $user->profile_photo);
                \Log::info('Deleted from public: profile_photos/' . $user->profile_photo);
            }
            // Hapus dari private (legacy)
            if (Storage::exists('private/public/profile_photos/' . $user->profile_photo)) {
                Storage::delete('private/public/profile_photos/' . $user->profile_photo);
                \Log::info('Deleted from private: private/public/profile_photos/' . $user->profile_photo);
            }
        }

        $file = $request->file('profile_photo');
        $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
        
        \Log::info('New filename: ' . $filename);
        
        // SIMPAN KE PUBLIC DISK
        $path = Storage::disk('public')->putFileAs('profile_photos', $file, $filename);
        $fullPath = Storage::disk('public')->path($path);
        chmod($fullPath, 0644);
        
        \Log::info('File saved to: ' . $path);
        \Log::info('Full path: ' . Storage::disk('public')->path($path));
        \Log::info('File exists: ' . (Storage::disk('public')->exists($path) ? 'YES' : 'NO'));
        
        $user->profile_photo = $filename;
    }

    $user->save();
    \Log::info('Profile updated for user: ' . $user->id . ', Photo: ' . $user->profile_photo);

    return back()->with('success', 'Profile updated successfully!');
}
}