<?php

namespace App\Controllers;

use App\Models\ChartModel;

class ChartController extends BaseController
{
    public function index()
    {
        $chartModel = new ChartModel();
        $data['chartData'] = $chartModel->getChartData();

        return view('chart_view', $data);
    }
}
