<?php

class AdminHomeController extends BaseController {

    public function getIndex() {

        return View::make('admins.index');
    }

}
