<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Session;

use App\Http\Requests;

class SocialAuth extends Controller
{
    //Provider: Google and Microsoft
    public function checkProvider($provider)
    {
    	if ($provider == 'Google') return 1;
    	if ($provider == 'Microsoft') return 2;
    	return 0;
    }

    public function getSocialRedirect($provider)
    {
    	$checkProvider = $this->checkProvider($provider);
    	if ($checkProvider == 1) return Socialite::with('google')->redirect();
    	if ($checkProvider == 2) return Socialite::with('live')->redirect();
    	return redirect('/');
    } 

    public function getSocialHandle($provider)
    {
    	$checkProvider = $this->checkProvider($provider);
    	if ($checkProvider == 1) $provider = 'google';
    	if ($checkProvider == 2) $provider = 'live';
    	if ($checkProvider == 0) return redirect('/');

    	$user = Socialite::driver($provider)->user();
        $email = $user->getEmail();
        $name = $user->getName();    	
        Session::flush();
        Session::put('email', $email);        
        Session::put('name', $name);
        return redirect()->action('StoreDatabase@Form');
    }

    public function Login()
    {        
        $hasEmail = Session::get('email');
        if ($hasEmail) return redirect('/Home');
    	return view('HTML.login');
    }
}
