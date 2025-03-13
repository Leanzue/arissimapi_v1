<?php

namespace App\Console\Commands\SimRequest;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\SimRequest\SimRequest;
use App\Imports\SimRequestResponseFilesImport;
use function Symfony\Component\Routing\Loader\Configurator\import;

class SimRequestImportResponseFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simrequest:import-responsefile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @param $SimRequest
     */
    public function handle($SimRequest)
    {
        $simrequest = SimRequest::getById(1);
        //dd($simrequest->response_file_name);
        $result = $simrequest->Importfile();
        //dd($result);
    }
}
