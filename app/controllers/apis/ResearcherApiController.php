<?php

class ResearcherApiController extends BaseController {

    public function getIndex() {

        $researchers = Researcher::with('faculty')->with('profileImage')->get();

        return $this->getResponse(true, $researchers);
    }

    public function postSave() {

        if (Input::has('id')) {
            $user = Researcher::findOrNew(Input::get('id'));
            $user->update(Input::except('profile_image'));

        } else {
            $user = Researcher::firstOrNew(Input::except('profile_image'));

        }

        $user->save();

        if (Input::has('faculty')) {
            $fid = (int) Input::get('faculty');
            $faculty = Faculty::find($fid);
            $user->faculty()->associate($faculty);
        } else {
            $user->faculty()->dissociate();
        }


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
            $researcher = Researcher::find(Input::get('id'));
            $researcher->delete();
            return $this->getResponse(true, null);
        } else {
            return $this->getResponse(false, null, "There are some error. Please Contact Administrator");
        }
    }

    public function getSearch($text) {

    $researcher = Researcher::whereNull('deleted_at')
        ->whereNested(function($query) use ($text) {
            $query->orWhere('firstname', '=~', ".*(?i)$text.*");
            $query->orWhere('lastname', '=~', ".*(?i)$text.*");
            $query->orWhere('title', '=~', ".*(?i)$text.*");
        })
        ->take(10)
        ->get();
    return Response::json($researcher);
}

}
