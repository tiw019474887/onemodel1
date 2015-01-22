<?php

class ResearchProjectApiController extends BaseController {
    

    public function getIndex() {

        $researchProjects = ResearchProject::with('researchers')->get();

        return $this->getResponse(true, $researchProjects);
    }

    public function getView($id){
        $researchProject = ResearchProject::find((int)$id)->with('researchers')->first();
        return $this->getResponse(true,$researchProject);
    }

    public function getViewPhoto($id,$skip=0){
        $researchProject = ResearchProject::find((int)$id);
        $photos = $researchProject->photos()->take(8)->skip((int)$skip)->get();
        return $this->getResponse(true,$photos,null);
    }

    public function postSave() {


        if (Input::has('id')) {
            $researchProject = ResearchProject::findOrNew(Input::get('id'));
            $researchProject->update(Input::all());
        } else {
            $researchProject = ResearchProject::firstOrNew(Input::all());
        }
        $researchProject->save();
        if (Input::has('researchers')) {
            $researchers = Input::get('researchers');
            $r_ids = [];
            foreach ($researchers as $r) {
                array_push($r_ids, (int) $r['id']);
            }
            $researchProject->researchers()->sync($r_ids);
        } else {
            $researchProject->researchers()->sync([]);
        }

        return $this->getResponse(true, $researchProject);
    }

    public function postDelete() {

        if (Input::has('id')) {
            $researchProject = ResearchProject::find(Input::get('id'));
            $researchProject->delete();

            return $this->getResponse(true, null, "Research Project [" + Input::get('id') + "] has been delete successfully.");
        } else {
            return $this->getResponse(false, null, "You must send [id] of ResearchProject to delete it");
        }
    }

    public function postUploadImage($id){
        $researchProject = ResearchProject::find((int)$id);

        if(Input::has('filename')){
            $filename = Input::get('filename');
            $filetype = Input::get('filetype');
            $base64 = Input::get('base64');

            $photo = $this->createPhoto($researchProject->id,$filename,$filetype,$base64);
            $photo->save();
            $researchProject->photos()->save($photo);

            return $this->getResponse(true,$photo,null);
        }
    }

    public function postDeletePhoto(){
        $id = Input::get('id');
        $photo = Photo::find((int)$id);
        $photo->photoable()->dissociate();
        $photo->delete();
        return $this->getResponse(true,null,null);
    }

}
