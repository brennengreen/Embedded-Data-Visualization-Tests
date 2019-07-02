<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class JSChart
{
    // What type of
    var $chartType;
    var $labels;
    var $datasets = array();
        var $chartLabel;
        var $dataPoints;
        var $backgroundColors;
        var $borderColors;
        var $borderWidth;


    public function __construct($type) {
        $this->chartType = $type;
    }

    public function set_labels($labels) {
        $this->labels = $labels;
    }

    public function set_datasets($label, $data, $bgColors, $bdColors, $bdWidth) {
        $this->chartLabel = $label;
        $this->dataPoints = $data;
        $this->backgroundColors = $bgColors;
        $this->borderColors = $bdColors;
        $this->borderWidth = $bdWidth;

        array_push($this->datasets, array(
           'label' => $this->chartLabel,
           'data' => $this->dataPoints,
           'backgroundColor' => $this->backgroundColors,
           'borderColor' => $this->borderColors,
           'borderWidth' => $this->borderWidth,
        ));
    }

    public function renderChart()
    {
        return array (
            'type' => $this->chartType,
            'data' => array (
                'labels' => $this->labels,
                'datasets' => $this->datasets
            ),
            'options' => array (
                'scales' => array (
                    'yAxes' => array (
                        'ticks' => array (
                            'beginAtZero' => true
                        )
                    )
                )
            )
        );
    }

}



class VisualizationController extends AbstractController
{
    public function homepage() {
        $chart = new JSChart("bar");
        $chart->set_labels(array ('2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019'));
        $chart->set_datasets(
            '# of Votes (by thousands',
            array (38, 72, 144, 100, 50, 60, 30, 50, 100),
            array(
                'rgba(255, 0, 0, .5)',
                'rgba(180, 25, 125, .5)',
                'rgba(192, 158, 30, .5)',
                'rgba(1, 111, 33, .5)',
                'rgba(255, 0, 150, .5)',
                'rgba(1, 155, 255, .5)',
                'rgba(255, 0, 0, .5)',
                'rgba(0, 0, 100, .5)',
            ),
            array(
                'rgba(255, 0, 0, .5)',
                'rgba(180, 25, 125, .5)',
                'rgba(192, 158, 30, .5)',
                'rgba(1, 111, 33, .5)',
                'rgba(255, 0, 150, .5)',
                'rgba(1, 155, 255, .5)',
                'rgba(255, 0, 0, .5)',
                'rgba(0, 0, 100, .5)',
            ),
            5
        );


        $chart2 = new JSChart("line");
        $chart2->set_labels(array ('2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019'));
        $chart2->set_datasets(
            '# of Votes (by thousands',
            array (38, 72, 144, 100, 50, 60, 30, 50, 100),
            'rgba(255, 0, 0, .5)',
            'rgba(255,0,0,.5)',
            5
        );

        $chartOneData = $chart->renderChart();
        $chartTwoData = $chart2->renderChart();
        $title = "Welcome to the Data Visualization Site";
        $desc = "Quick and Useful Data Visualizations";


        return $this->render('index.html.twig', [
           'title' => $title,
            'desc' => $desc,
            'chartOne' => json_encode($chartOneData),
            'chartTwo' => json_encode($chartTwoData)
        ]);
    }

}