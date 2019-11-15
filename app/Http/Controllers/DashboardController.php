<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class DashboardController extends Controller
{

    /**
     * Oct. 19, 2019
     * @author john kevin paunel
     * Dashboard view
     * @return mixed
     * */
    public function dashboard()
    {
        $chart_options1 = [
            'chart_title' => 'Job Orders',
            'chart_type' => 'line',
            'report_type' => 'group_by_date',
            'model' => 'App\JobOrder',

            'group_by_field' => 'created_at',
            'group_by_period' => 'day',

            'filter_field' => 'created_at',
            'filter_days' => 30, // show only transactions for last 30 days
            'filter_period' => 'week', // show only transactions for this week
            'continuous_time' => true, // show continuous timeline including dates without data
        ];
        $chart1 = new LaravelChart($chart_options1);

        $chart_options = [
            'chart_title' => 'Job Order Status',
            'report_type' => 'group_by_string',
            'model' => 'App\JobOrder',
            'group_by_field' => 'status',
            'aggregate_function' => 'count',
            'aggregate_field' => 'status',
            'chart_type' => 'pie',
            'filter_field' => 'created_at',
            'filter_period' => 'month', // show users only registered this month
        ];

        $chart2 = new LaravelChart($chart_options);

        $chart_options = [
            'chart_title' => 'User Task Contribution',
            'report_type' => 'group_by_relationship',
            'model' => 'App\task',
            'relationship_name' => 'users', // represents function user() on Transaction model
            'group_by_field' => 'username', // users.name
            'aggregate_function' => 'count',
            'aggregate_field' => 'status',
            'chart_type' => 'pie',
            'filter_field' => 'created_at',
            'filter_period' => 'month', // show users only registered this month
        ];

        $chart3 = new LaravelChart($chart_options);

        $chart_options = [
            'chart_title' => 'Tasks Status',
            'report_type' => 'group_by_string',
            'model' => 'App\task',
            'group_by_field' => 'status', // users.name
            'aggregate_function' => 'count',
            'aggregate_field' => 'status',
            'chart_type' => 'pie',
            'filter_field' => 'created_at',
            'filter_period' => 'month', // show users only registered this month
        ];

        $chart4 = new LaravelChart($chart_options);

        return view('pages.dashboard', compact('chart1','chart2','chart3','chart4'));
    }
}
