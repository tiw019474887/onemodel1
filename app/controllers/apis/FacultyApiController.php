<?php

class FacultyApiController extends BaseController {

    public function getIndex() {

        $faculties = Faculty::all();

        return $this->getResponse(true, $faculties);
    }

    public function postSave() {


        if (Input::has('id')) {
            $faculties = Faculty::findOrNew(Input::get('id'));
            $faculties->update(Input::all());
        } else {
            $faculties = Faculty::firstOrNew(Input::all());
        }

        $faculties->save();

        return $this->getResponse(true, $faculties);
    }

    public function postDelete() {
        if (Input::has('id')) {
            $faculty = Faculty::find(Input::get('id'));
            $faculty->delete();

            return $this->getResponse(true, null);
        } else {
            return $this->getResponse(false, null, "There are some error. Please Contact Administrator");
        }
    }
    public function getSearch($text) {

        $fuculty = Faculty::whereNull('deleted_at')
            ->whereNested(function($query) use ($text) {
                $query->orWhere('name_th', '=~', ".*(?i)$text.*");
                $query->orWhere('name_en', '=~', ".*(?i)$text.*");

            })
            ->take(10)
            ->get();
        return Response::json($fuculty);
    }

}
