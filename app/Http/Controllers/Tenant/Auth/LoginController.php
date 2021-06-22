<?php

namespace App\Http\Controllers\Tenant\Auth;

use App\Tenant\TenantRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Notifications\MailResetPasswordToken;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller{
    use AuthenticatesUsers;

    protected $guard        = 'tenant';
    protected $tenant;

	protected $adminUser;
	public function __construct(TenantRepository $tenant){
		$this->tenant	= $tenant;
	}

    public function index(){
        return view('tenant.auth.login');
    }

    public function authenticate(Request $request){
        if(Auth::guard('tenant')->attempt($request->only('email','password'),1)){
            //Authentication passed...
            alertNotify(true, "Success logged in as Tenant", $request);
            return redirect(url('tenant/dashboard'));
        }else{
            alertNotify(false, "Email or password doesn't match!", $request);
            return redirect()->back();
        }
    }

    public function logout(Request $request){
        $adminUser  = Auth::guard('tenant')->logout();

        return redirect('tenant/login');
    }

    public function reset(){
        return view('tenant.auth.reset');
    }


    public function resetPassword(Request $request){
        $email  = $request->get('email');
        $user   = $this->tenant->findUserByEmail($email);
        $token  = $this->tenant->generateTokenForgotPassword($user);

        if($token){

            $request->session()->flash('alert-class','success');
            $request->session()->flash('status', 'Forgot password success sent');
            $user->notify(new MailResetPasswordToken($token));
        }

        return redirect('tenant/login');
    }

    public function resetToken($token = "", Request $request){
        $reset  = $this->tenant->getUserByToken($token);
        if(!$reset){
            $request->session()->flash('alert-class','danger');
            $request->session()->flash('status', 'Token salah/expired');

            return redirect('tenant/login');
        }
        return view('tenant.auth.change-pass', compact('token', 'user'));
    }

    public function changePass($token = "", Request $request){
        $reset       = $this->tenant->getUserByToken($token);
        $newPass    = $request->get('password');
        if(!$reset){
            $request->session()->flash('alert-class','error');
            $request->session()->flash('status', 'Token salah/expired');

            return redirect('tenant/login');
        }

        $this->tenant->changePassword($reset->email, $newPass);

        $request->session()->flash('alert-class','success');
        $request->session()->flash('status', 'Password changed, now you can login with your new password');

        $user   = $this->tenant->findByEmail($reset->email);

        return redirect('tenant/login');
    }

}
