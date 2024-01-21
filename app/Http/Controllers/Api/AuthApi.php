<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthApi extends Controller
{
    
    public function changePassword()
    {
        $user_id = request()->user_id;
        $current_password = request()->currentPassword;
        $new_password = request()->newPassword;

        $user = User::where('id', $user_id)->first();
        
        if(Hash::check($current_password, $user->password))
        {

        }
        else{
            return response()->json([
                'message' => false,
                'data' => 'Current Password is Incorrect'
            ]);
        
        }

    }
}
