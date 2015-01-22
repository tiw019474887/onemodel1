<?php

class BaseController extends Controller {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout() {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

    protected function getResponse($success, $data, $message = '') {
        return Response::json([
                    'success' => $success,
                    'data' => $data,
                    'message' => $message
        ]);
    }

    protected function createPhoto($nodeid,$filename,$filetype,$base64){

        $fileurlpath = "/up/node/$nodeid/";
        $uppath = public_path()."/up/";
        $nodepath = $uppath."node/";
        $idpath = $nodepath.$nodeid;

        if (!File::exists($uppath)){
            File::makeDirectory($uppath);
        }
        if (!File::exists($nodepath)){
            File::makeDirectory($nodepath);
        }
        if (!File::exists($idpath)){
            File::makeDirectory($idpath);

        }

        if($filename){
            $filename = str_random(10)."_".$filename;
            $filefullname = $idpath."/".$filename;

            $photo = new Photo();
            $photo->filename = $filename;
            $photo->filetype = $filetype;

            $photo->url = $fileurlpath.$filename;

            File::put($filefullname,base64_decode($base64));

            return $photo;

        }
    }

}
