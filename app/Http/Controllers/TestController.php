<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Treatment\Services\ExecBatchService;

class TestController extends Controller
{
    public function testsip() {
        $host = ExecBatchService::$SERVER_IP;
        $pingResult = shell_exec("ping -n 1 -w 5 " . escapeshellarg($host));

        if (strpos($pingResult, 'TTL') !== false) {
            dd("host: ". $host .", Ping réussi, IP OK");
        } else {
            dd("host: ". $host .", Ping échoué, IP NO OK");
        }

    }

}
