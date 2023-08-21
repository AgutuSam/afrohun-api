<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    use HttpResponses;
public function logout(Request $request){
        $request= auth()->user()->tokens()->delete();
           If ($request){ return $this->success([
                'message'=>'Logged out'
            ]);}
        // Member::logout();
        // return response()->json(['message' => 'Logged out successfully']);
    }

}