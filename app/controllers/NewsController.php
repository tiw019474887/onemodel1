<?php

class NewsController extends BaseController {

    public function getIndex() {

        return View::make('news.index');
    }

}
