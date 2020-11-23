<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index() {
        // Test only
        return [
            ['t' => date('Y-m-d H:i:s', strtotime('-3 hours')), 'y' => 2],
            ['t' => date('Y-m-d H:i:s', strtotime('-2 hours')), 'y' => 5],
            ['t' => date('Y-m-d H:i:s', strtotime('-1 hour')), 'y' => 3],
        ];
    }
}
