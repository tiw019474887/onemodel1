<?php

class UserApiController extends BaseController {

    public function getIndex() {

        $users = User::with(['profileImage'])->get();

        return $this->getResponse(true, $users);
    }

    public function postSave() {

        if (Input::has('id')) {
            $user = User::findOrNew(Input::get('id'));
            $user->update(Input::all());
        } else {
            $user = User::firstOrNew(Input::all());
            if (Input::has('email')){
                if(!User::isUniqueEmail(Input::get('email'))){
                    return $this->getResponse(false,null,'Email Address is not valid.');
                }
            }

        }

        if (Input::has(['password', 'verifypassword'])) {
            $password = Input::get('password');
            $verifypassword = Input::get('verifypassword');

            if ($password == $verifypassword) {
                $user->password = Hash::make($password);
            }
        }

        $user->save();


        if (Input::has('profile_image')) {

            $filename = Input::get('profile_image.filename');
            $filetype = Input::get('profile_image.filetype');

            if(Input::has('profile_image.base64')){
                $base64 = Input::get('profile_image.base64');
                $photo = $this->createPhoto($user->id,$filename,$filetype,$base64);
                $user->profileImage()->save($photo);
            }

        }


        return $this->getResponse(true, $user);
    }

    public function postDelete() {
        if (Input::has('id')) {
            $user = User::find(Input::get('id'));
            $user->delete();
            return $this->getResponse(true, null);
        } else {
            return $this->getResponse(false, null, "There are some error. Please Contact Administrator");
        }
    }

    public function postLogin() {

        $email = Input::get('email');
        $password = Input::get('password');

        if (Auth::attempt(array('email' => $email, 'password' => $password))) {
            return $this->getResponse(true, Auth::user());
        } else {
            return $this->getResponse(false, null, "Username or password is invalid");
        }
    }

    public function postLogout(){
        Auth::logout();
        return $this->getResponse('true',null,null);
    }

    public function getCurrentUser() {

        if (Auth::check()){
            $user = Auth::user();
            $user = User::find($user->id)->with('profileImage')->first();

            return[
                'sucess' => true,
                'data' => $user,
                'massage' => null
            ];
        }else {

            return[
                'sucess' => true,
                'data' => null,
                'massage' => null
            ];
        }

    }


}
