<?php

class StatisticsController extends Controller {

    public function index() {
        $model = new StatisticsModel();
        $yearsArray = $model->getYearsArray();
        $statesArray = $model->getStatesArray();

        $this->view('statistics' . DIRECTORY_SEPARATOR . 'index', ["yearsArray" => $yearsArray,
                                                                   "statesArray" => $statesArray]);
    }
    
}