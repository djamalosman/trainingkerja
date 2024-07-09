<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\MenuModel;
use Exception;
use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\MetricAggregation;
use Google\Analytics\Data\V1beta\NumericValue;
use Google\Analytics\Data\V1beta\OrderBy;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'IFG | Dashboard';
        $data['title_page'] = 'Dashboard | Dashboard';
        $data['menu'] = MenuModel::all();

        $data['arrDay'] = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'];
        $data['arrMonthBefore'] = [];
        $data['arrCurrentMonth'] = [];
        $data['totalMonthBefore'] = 0;
        $data['totalCurrentMonth'] = 0;
        $data['newUsers'] = 0;
        $data['totalUsers'] = 0;
        $data['newUsersBefore'] = 0;
        $data['totalUsersBefore'] = 0;
        $data['percentageOverTime'] = 0;

        $data['filterMonth'] = $request->month ?? '';
        $data['filterYear'] = $request->year ?? '';

        $day = date('d');
        $dayMonthBefore = date("t", strtotime('-1 month'));


        // if ($request->month == '' && $request->year == '') {
        //     $data['trafficBefore'] = $this->analytics('oneMonthBefore');
        //     $data['trafficNow'] = $this->analytics('currentMonth');

        //     if ($data['trafficBefore'] != "error") {

        //         foreach ($data['trafficBefore']->getRows() as $row) {
        //             if (in_array($row->getDimensionValues()[0]->getValue(), $data['arrDay'])) {
        //                 array_push($data['arrMonthBefore'], $row->getMetricValues()[0]->getValue());
        //                 $data['totalMonthBefore'] += $row->getMetricValues()[0]->getValue();
        //             } else {
        //                 array_push($data['arrMonthBefore'], 0);
        //             }
        //         }


        //         do {
        //             array_push($data['arrMonthBefore'], 0);
        //         } while (count($data['arrMonthBefore']) < $dayMonthBefore);



        //         foreach ($data['trafficNow']->getRows() as $row) {
        //             // print $row->getDimensionValues()[0]->getValue() . PHP_EOL;
        //             if (in_array($row->getDimensionValues()[0]->getValue(), $data['arrDay'])) {
        //                 array_push($data['arrCurrentMonth'], $row->getMetricValues()[0]->getValue());
        //                 $data['totalCurrentMonth'] += $row->getMetricValues()[0]->getValue();
        //             } else {
        //                 array_push($data['arrCurrentMonth'], 0);
        //             }
        //         }

        //         do {
        //             array_push($data['arrCurrentMonth'], 0);
        //         } while (count($data['arrCurrentMonth']) < $day);

        //         $totalsTrafficBefore = $data['trafficBefore']->getTotals();
        //         // echo count($totalsTrafficBefore) ; die();
        //         $totalsTrafficNow = $data['trafficNow']->getTotals();

        //         if (isset($totalsTrafficBefore) && !empty($totalsTrafficBefore)) {
        //             foreach ($totalsTrafficBefore as $row) {
        //                 if (count($row->getMetricValues()) != 0) {
        //                     $data['newUsersBefore'] = $row->getMetricValues()[2]->getValue();
        //                     $data['totalUsersBefore'] = $row->getMetricValues()[1]->getValue();
        //                 }
        //             }
        //         }

        //         // dd($totalsTrafficNow);
        //         if (isset($totalsTrafficNow) && !empty($totalsTrafficNow)) {
        //             foreach ($totalsTrafficNow as $row) {
        //                 // foreach ($row->getMetricValues() as $metricValue) {
        //                 //     $data['totalCurrentMonth'] = $metricValue->getValue();
        //                 // }
        //                 if (count($row->getMetricValues()) != 0) {
        //                     // $data['totalCurrentMonth'] = $row->getMetricValues()[0]->getValue();
        //                     $data['newUsers'] = $row->getMetricValues()[2]->getValue();
        //                     $data['totalUsers'] = $row->getMetricValues()[1]->getValue();
        //                 }
        //             }
        //         }

        //         if ($data['totalMonthBefore'] > 0 && $data['totalCurrentMonth'] > 0) {
        //             $data['percentageOverTime'] = number_format((float)($data['totalMonthBefore'] - $data['totalCurrentMonth']) / $data['totalMonthBefore'] * 100, 2, '.', '');
        //         }
        //     }
        // } else {
        //     $data['trafficNow'] = $this->analytics('filter', $request->month, $request->year);

        //     if ($data['trafficNow'] != "error") {

        //         foreach ($data['trafficNow']->getRows() as $row) {
        //             if (in_array($row->getDimensionValues()[0]->getValue(), $data['arrDay'])) {
        //                 array_push($data['arrCurrentMonth'], $row->getMetricValues()[0]->getValue());
        //                 $data['totalCurrentMonth'] += $row->getMetricValues()[0]->getValue();
        //             } else {
        //                 array_push($data['arrCurrentMonth'], 0);
        //             }
        //         }

        //         do {
        //             array_push($data['arrCurrentMonth'], 0);
        //         } while (count($data['arrCurrentMonth']) < $day);

        //         $totalsTrafficNow = $data['trafficNow']->getTotals();


        //         // dd($totalsTrafficNow);
        //         if (isset($totalsTrafficNow) && !empty($totalsTrafficNow)) {
        //             foreach ($totalsTrafficNow as $row) {
        //                 if (count($row->getMetricValues()) != 0) {
        //                     $data['newUsers'] = $row->getMetricValues()[2]->getValue();
        //                     $data['totalUsers'] = $row->getMetricValues()[1]->getValue();
        //                 }
        //             }
        //         }

        //         if ($data['totalCurrentMonth'] > 0) {
        //             $data['percentageOverTime'] = 0;
        //         }
        //     }
        // }

        return view('pages.dashboard', $data);
    }

    public function analytics($key, $month = '', $year = '',)
    {
        try {

            $path = "credentialsrevamp.json";
            // $path = "credentials.json";
            putenv("GOOGLE_APPLICATION_CREDENTIALS=" . storage_path() . '/' . $path);

            $property_id = '360582427';
            $client = new BetaAnalyticsDataClient();

            if ($key == 'oneMonthBefore') {
                $startDate = date("Y-m-01", strtotime('-1 month'));
                $endDate = date("Y-m-t", strtotime('-1 month'));
            } else if ($key == 'currentMonth') {
                $startDate = date("Y-m-01");
                $endDate = date("Y-m-t");
            } else {
                $startDate = date("Y-m-01", strtotime($month . ' ' . $year));
                $endDate = date("Y-m-t", strtotime($month . ' ' . $year));
            }

            $response = $client->runReport([
                'property' => 'properties/' . $property_id,
                'dateRanges' => [
                    new DateRange([
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                    ]),
                ],
                'dimensions' => [
                    new Dimension(
                        [
                            'name' => 'day',
                            // "sortOrder"=> "DESCENDING"
                        ]
                    ),
                ],
                'metrics' => [
                    new Metric(
                        [
                            'name' => 'activeUsers',
                        ],

                    ),
                    new Metric([
                        "name" => "totalUsers"
                    ]),
                    new Metric([
                        "name" => "newUsers"
                    ])
                ],

                'orderBys' => [
                    new OrderBy([
                        'dimension' => new OrderBy\DimensionOrderBy([
                            'dimension_name' => 'day', // your dimension here
                            'order_type' => OrderBy\DimensionOrderBy\OrderType::NUMERIC
                        ]),
                        'desc' => false,
                    ]),
                ],
                'keepEmptyRows' => true,
                'metricAggregations' => [
                    MetricAggregation::TOTAL,
                ],
            ]);
        } catch (Exception $e) {
            $response = $e;
        }
        return $response;
    }
}
