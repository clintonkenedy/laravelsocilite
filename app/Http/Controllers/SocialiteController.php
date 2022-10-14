<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Illuminate\Support\Facades\Auth;

class SocialiteController extends Controller
{
    //
    public function redirectFacebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function callbackFacebook(){
        //try {

            $facebookUser = Socialite::driver('facebook')->user();
            $findUser = User::where('fb_id',$facebookUser->id)->first();
            dd($findUser);
            /*if($findUser){
                Auth::login($findUser);
                return redirect()->intended('home');
            }
            else{
                $newUser = User::create([
                    'name'=>$facebookUser->name,
                    'email'=>$facebookUser->email,
                    'fb_id'=>$facebookUser->id,
                    'password'=>encrypt('12345678')
                ]);
                Auth::login($newUser);
            }
        }catch (Exception $e){
            dd($e->getMessage());
        }*/
    }

    public function redirectGithub(){
        return Socialite::driver('github')->redirect();
    }

    public function callbackGithub(){
        try {

            $githubUser = Socialite::driver('github')->user();
            $findUser = User::where('gh_id',$githubUser->id)->first();
            if($findUser){
                Auth::login($findUser);
                return redirect()->intended('home');
                dd($findUser);

            }
            else{
                //dd($githubUser);
                $newUser = User::create([
                    'name'=>$githubUser->nickname,
                    'email'=>$githubUser->email,
                    'gh_id'=>$githubUser->id,
                    'password'=>encrypt('12345678')
                ]);
                Auth::login($newUser);
                return redirect()->intended('home');
            }
        }catch (Exception $e){
            dd($e->getMessage());
        }
    }
}
