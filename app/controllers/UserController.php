<?php

class UserController extends BaseController {

    public function getIndex() {

        $users = User::all();


        return View::make('users.index')
                        ->with("users", $users);
    }

    public function postCreate() {

        $user = new User();
        $user->fill(Input::all());

        if (Input::has(['password', 'verifypassword'])) {
            $password = Input::get('password');
            $verifypassword = Input::get('verifypassword');

            if ($password == $verifypassword) {
                $user->password = Hash::make($password);
            }
        }

        $user->save();
        return Redirect::action('UserController@getIndex');
    }

    public function showLogin(){
        if (Auth::Check()){
            return Redirect::to('admin');
        }
        return View::make('users.login');
    }

    public function showLogout(){
        Auth::logout();
        return Redirect::to('/login');
    }

}
