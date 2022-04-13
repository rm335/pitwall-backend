<?php

namespace App\Http\Controllers;
use App\Models\Calendar;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Laravel\Lumen\Routing\Controller as BaseController;

class CalendarController extends BaseController
{

    public $requestController;

    public function __construct() {
       $this->requestController = new RequestController();
    }

    public function getAvailable(Request $request) {

        if(!$this->requestController->isValid($request)) { return; }
        
        Carbon::setLocale('nl');

        $rounds = Calendar::getRaces();
        $response = [];

        foreach ($rounds as $round) {

            $roundResponse = [];
            $gmtOffset = substr($round[count($round) - 1]->gmt_offset, 0, -3);

            $start = $round[0]->start;
            $start = Carbon::parse($start);
            if ($gmtOffset[0] == "+") {
                $start = $start->addHours(intval($gmtOffset));
            } else {
                $start = $start->subHours(intval($gmtOffset));
            }
            $start = $start->subHours(2);
            $start = $start->day;

            $end = $round[count($round) - 1]->start;
            $end = Carbon::parse($end);
            if ($gmtOffset[0] == "+") {
                $end = $end->addHours(intval($gmtOffset));
            } else {
                $end = $end->subHours(intval($gmtOffset));
            }
            $end = $end->subHours(2);
            $month = $end->getTranslatedMonthName();
            $month = ucfirst($month);
            $end = $end->day;

            $startQ = "";
            $startR = "";

            foreach ($round as $item) {

                $isDST = Carbon::parse($item->start)->isDST();

                if ($item->type == "Qualifying") {
                    $itemStart = $item->start;
                    $itemStart = Carbon::parse($itemStart);
                    $gmtOffset = substr($item->gmt_offset, 0, -3);
                    $itemStart = $itemStart->subHours(intval($gmtOffset));
                    $itemStart = $itemStart->addHours($isDST ? 2 : 1);
                    $startQ = "Q: {$itemStart->format("H:i")}";
                } else if ($item->type == "Sprint Qualifying") {
                    $itemStart = $item->start;
                    $itemStart = Carbon::parse($itemStart);
                    $gmtOffset = substr($item->gmt_offset, 0, -3);
                    $itemStart = $itemStart->subHours(intval($gmtOffset));
                    $itemStart = $itemStart->addHours($isDST ? 2 : 1);
                    $startQ = "SQ: {$itemStart->format("H:i")}";
                } else if ($item->type == "Race") {
                    $itemStart = $item->start;
                    $itemStart = Carbon::parse($itemStart);
                    $gmtOffset = substr($item->gmt_offset, 0, -3);
                    $itemStart = $itemStart->subHours(intval($gmtOffset));
                    $itemStart = $itemStart->addHours($isDST ? 2 : 1);
                    $startR = "R: {$itemStart->format("H:i")}";
                }
            }

            foreach ($round as $item) {

                $start_nl = Carbon::parse($item->start);

                $start_nl = $start_nl->subHours(intval($gmtOffset));
                $isDST = $start_nl->isDST();
                $start_nl = $start_nl->addHours($isDST ? 2 : 1);

                $start_nl = $start_nl->toDateTimeString();

                if (strtolower($item->type) == "race") {
                    $roundResponse[] = [                                                
                        "start_end" => "{$start} - {$end} {$month}",
                        "start_end_hours" => "{$startQ} - {$startR}",                                                                  
                        "circuit" => $item->circuit_short_name,
                        "country" => $item->country,
                        "country_flag_url" => $item->country_flag_url,
                        "circuit_light_img_url" => $item->circuit_light_img_url,
                        "circuit_dark_img_url" => $item->circuit_dark_img_url,
                        "winner" => $item->winner,
                        "round" => $item->round,
                        "rounds" => count($rounds),                        
                    ];
                }
            }

            $response[] = $roundResponse;
        }

        $result = [];

        foreach ($response as $item) {
            if(count($item) > 0){
                $result[] = $item[0];
            }
        }
        
        if (count($result) == 0) {
            return response()->json(["items_count" => 0], 204);
        }

        return response()->json($result);
    }

}