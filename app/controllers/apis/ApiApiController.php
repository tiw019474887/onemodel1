<?php

class ApiApiController extends BaseController {

    public function getIndex() {

        $apis = Api::all();

        return $this->getResponse(true, $apis);
    }

    public function postGenerate() {
        $api = new Api();
        $str = Str::random();
        $api->key = Hash::make($str);
        $api->status = true;
        $api->save();
    }

    public function postToggle() {
        $api = Input::get('id');
        $api->update(Input::all());
        $api->save();
        return $api;
    }

    public function postSave() {


        if (Input::has('id')) {
            $api = Api::findOrNew(Input::get('id'));
            $api->update(Input::all());
        } else {
            $api = Api::firstOrNew(Input::all());
        }

        $api->save();

        return $this->getResponse(true, $api);
    }

    public function postDelete() {
        if (Input::has('id')) {
            $api = Api::find(Input::get('id'));
            $api->delete();
            return $this->getResponse(true, null);
        } else {
            return $this->getResponse(false, null);
        }
    }

}
