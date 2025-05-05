<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function AdminDashboard(){
        return view('admin.index');
    }

    public function AdminLogout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    public function AdminLogin(){
        return view('admin.admin-login');
    }

    public function AdminProfile(){
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin-profile', compact('profileData'));
    }

    public function AdminProfileStore(Request $request){
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->username = $request->username;
        $data->name = $request->name;
        // $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        
        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/' . $data->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $data['photo'] = $filename;
        }
        $data->save();
        $notification = array(
            'message' => 'Profile Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.profile')->with($notification);
    }

    public function AdminChangePassword(){
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin-change-password', compact('profileData'));
    }

    public function AdminUpdatePassword(Request $request)
    {
        // Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);

        // Check if the old password is correct
        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return back()->with([
                'message' => 'Old Password is Incorrect',
                'alert-type' => 'error'
            ]);
        }

        // Check if the new password is the same as the old password
        if ($request->old_password === $request->new_password) {
            return back()->with([
                'message' => 'New Password must be different from the Old Password',
                'alert-type' => 'warning'
            ]);
        }

        // Update the password
        $user = User::find(Auth::id());
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with([
            'message' => 'Password Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    // public function AdminUpdatePassword(Request $request){
        
    //     // Validation
    //     $request->validate([
    //         'old_password' => 'required',
    //         'new_password' => 'required|confirmed|min:8',
    //     ]);

    //     // Check if the old password is correct
    //     if (!Hash::check($request->old_password, Auth::user()->password)) {
    //         $notification = array(
    //             'message' => 'Old Password is Incorrect',
    //             'alert-type' => 'error'
    //         );
    //         return back()->with($notification);

    //     // Update the password
    //     // User::where('id', Auth::user()->id)->update([
    //     //     'password' => Hash::make($request->new_password)
    //     // ]);
    //     User::whereId(Auth::user()->id)->update([
    //         'password' => Hash::make($request->new_password)
    //     ]);
    //         $notification = array(
    //             'message' => 'Password Updated Successfully',
    //             'alert-type' => 'success'
    //         );
    //         return back()->with($notification);
    //     }
    // }

}
