<?php

class NewsApiController extends BaseController
{

    public function getIndex()
    {

        $news = News::all();
        return $this->getResponse(true, $news);
    }

    public function getEdit($id)
    {
        $news = News::find((int)$id);
        return $this->getResponse(true, $news);
    }

    public function getPhotos($id,$skip=0){
        $news = News::find((int)$id);
        $photos = $news->getPhotos($skip);
        return $this->getResponse(true,$photos,null);
    }


    public function postSave()
    {


        if (Input::has('id')) {
            $news = News::findOrNew(Input::get('id'));
            $news->update(Input::all());
        } else {
            $news = News::firstOrNew(Input::all());
        }

        $news->save();

        if (Auth::check()) {
            $user = Auth::user();
            $news->user()->associate($user);
        }

        return $this->getResponse(true, $news);
    }

    public function postDelete()
    {
        if (Input::has('id')) {
            $news = News::find(Input::get('id'));
            $news->delete();
            return $this->getResponse(true, null);
        } else {
            return $this->getResponse(false, null);
        }
    }

    public function postUploadImage($id){
        $news = News::find((int)$id);

        if(Input::has('filename')){
            $filename = Input::get('filename');
            $filetype = Input::get('filetype');
            $base64 = Input::get('base64');

            $photo = $this->createPhoto($news->id,$filename,$filetype,$base64);
            $photo->save();
            $news->photos()->save($photo);

            return $this->getResponse(true,$photo,null);
        }
    }

}
