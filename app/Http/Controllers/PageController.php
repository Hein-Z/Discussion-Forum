<?php

namespace App\Http\Controllers;


use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class PageController extends Controller
{

    public function editProfile()
    {
        return Inertia::render('EditUser.vue');
    }

    public function updateProfile(Request $request)
    {
        ##validate
        $request->validate([
            'name' => 'required',
            'email' => 'email|required',
        ]);
        ##fetch user
        $id = Auth::user()->id;
        $user = User::where('id', $id);

        ##check password
        if ($request->password) {
            $request->validate(['password' => 'min:6']);
            $hash = Hash::make($request->password);
        } else {
            $hash = $user->first()->password;
        }
        ##check image
        if ($request->file('image')) {
            $request->validate(['image' => 'image|mimes:png,jpg,jpeg']);
            $image = $request->file('image');
            $image_name = uniqid() . str_replace(' ', '', $image->getClientOriginalName());
            $image_path = '/images/profile/';
            $image->move(public_path('images/profile'), $image_name);
            $image_name_path = $image_path . $image_name;

            $cur_image = $user->first()->image;
            if ($cur_image !== '/images/profile/default.jpg') {
                File::delete($cur_image);
            }
        } else {
            $image_name_path = $user->first()->image;
        }
        ##update user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $hash,
            'image' => $image_name_path
        ]);

        return redirect()->back()->with('success', 'Successfully updated');
    }

}
