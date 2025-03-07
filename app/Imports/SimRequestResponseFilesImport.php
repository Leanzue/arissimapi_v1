<?php

namespace App\Imports;

use App\Models\SimRequest\SimRequest;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\SimRequest\SimRequestResponseFile;

class SimRequestResponseFilesImport implements ToModel, WithHeadingRow, WithStartRow
{
    // TODO: Squiper la 1ere ligne.
    /**
     * @var SimRequest
     */
    public $simrequest;

    public function __construct(SimRequest $simrequest)
    {
        $this->simrequest = $simrequest;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $new_imported_file =  new SimRequestResponseFile([
            'iccid'     => $row['icc'],
            'status'    => $row['status'],
            'status_change_date_str' => $row['statuschangedate'],
        ]);

        // liaison du sim request
        $new_imported_file->simrequest()->associate($this->simrequest)->save();

        return $new_imported_file;
    }

    public function startRow(): int
    {
        return 2;
    }

}
