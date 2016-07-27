<?php

namespace App\Http\Controllers\Auth;
use Auth;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use Laracasts\Flash\Flash;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $users;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->users = $user;
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request)
    {
        $rules = [
            'email' => 'required|exists:users',
            'password' => 'required'
        ];

        $input = $request->only('email', 'password');

        $validator = Validator::make($input, $rules);

        if($validator->fails())
        {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        $inputs = [
            'email' => $input['email'],
            'password' => $input['password'],
        ];
        $remember = $request->get('remember_me');

        $user = User::where(['email'=>$input['email']])->get();
        if($user AND $user[0]->status ==0) {
            Flash::error('Please activate your account to procceed.');
            return Redirect::to('/login')
                ->withInput();
        }
        if (Auth::attempt($inputs, $remember))
        {
            return redirect()->intended('jobpost/index');
        }
        Flash::error('Username or password mismatch.');
        return Redirect::to('/login')->withInput();
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {

        $data['verification_code'] = str_random(30);
        $data['link'] = route('auth.email.verify', $data['verification_code']);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'verification_code' => $data['link'],
            'status' => 0
        ]);


        $subject = 'Email Verification';
        $this->sendMail($data['link'],$data['email'],'info@demoproject.net',$subject);

        Flash::success('Registered successfully. Please check your email for verification link.');
        $this->redirectTo = '/login';

        return $this->users;
    }

    public function sendMail($data,$to,$from,$subject){
        Mail::send('auth.verify', ["data" => $data], function ($message) use($to,$from,$subject) {

            $message->from($from, 'Job Portal');

            $message->to($to)->subject($subject);
        });
    }

    public function confirmEmail($verification_code){
        try {
            if( ! $verification_code)
            {
                throw new InvalidArgumentException;
            }

            $user = User::where('verification_code',route('auth.email.verify', $verification_code))->first();

            if ( ! $user)
            {
                throw new InvalidArgumentException;
            }

            $oldDate = strtotime($user['created_at']);
            $currentDate = strtotime(Carbon::now()->toDateTimeString());

            if ($currentDate-$oldDate>=86400)
            {
            Flash::error('Activation time expired.'."<a href='#'>click here to resend</a>");
                Flash::error('Activation time expired. please contact to Administrator.');
                return redirect('login');
            }
            $user->status = 1;
            $user->verification_code = null;
            $user->save();
            Flash::success('Account verified successfully !');
            return redirect('login');
        } catch (\Exception $e) {
//            Flash::error(trans('messages.exception_thrown'), ['message' => $e->getMessage()]);
            return redirect()->back();
        }

    }
}
