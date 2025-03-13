<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Sim\Sim;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Models\SimRequest\SimRequest;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Illuminate\Contracts\Database\Query\Builder;
use App\Models\SimRequest\SimRequestResponseFile;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;

class SimRequestResponseFilesImport implements ToModel, WithHeadingRow, WithEvents, WithValidation, SkipsOnFailure
{
    use RemembersRowNumber, Importable, SkipsFailures;

    /**
     * @var SimRequest
     */
    public $simrequest;
    public $nb_row_imported;
    public $error_message_arr;
    public $error_message_str;
    public $total_rows = 0;
    private $_current_row = 0;

    //public $treatment;

    /**
     * Constructeur de la classe.
     *
     * @param SimRequest $simrequest
     */
    public function __construct(SimRequest $simrequest)
    {
        $this->simrequest = $simrequest;

        $this->nb_row_imported = 0; // Initialisation correcte
        $this->error_message_arr = []; // Initialisation des messages d'erreur

        //$this->treatment = $treatment;

        $this->_current_row = 1;
    }

    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $current_row = $this->getRowNumber();

        // Journaux pour déboguer
        Log::info("Début du traitement de la ligne (". $current_row ." / ". $this->total_rows .") : ", $row);

        /*if ($current_row == 1) {
            return null;
        }*/

        // Validation des données dans la ligne
        /*if (trim($row['icc'], '-') === '' || trim($row['status'], '-') === '' || trim($row['statuschangedate'], '-') === '') {
            Log::warning("Champs 'ICC', 'STATUS' ou 'STATUSCHANGEDATE' vide", $row);
            $this->addErrorMessage("Champs 'ICC', 'STATUS' ou 'STATUSCHANGEDATE' vide");
            return null; // Ignore la ligne
        }*/

        // Vérification de l'existence de l'ICCID
        /*$sim = Sim::where('iccid', $row['icc'])->first();
        Log::info($sim);

        if (! $sim) {
            $this->addErrorMessage("ICCID introuvable : " . $row['icc']);
            Log::warning("ICCID introuvable : " . $row['icc']);
            return null; // Ignorer cette ligne
        }*/

        // Gestion de la date
        try {
            $parsed_date = Carbon::parse($row['statuschangedate']); // Conversion en objet Carbon
        } catch (\Exception $e) {
            // Ignorer cette ligne$this->error_message[] = "Date invalide pour l'ICCID : " . $row['icc'];
            Log::error("Date invalide pour l'ICCID : " . $row['icc']);
            $this->addErrorMessage("Date invalide pour l'ICCID : " . $row['icc']);
            //return null;
            $parsed_date = $row['statuschangedate'];
        }

        // Création de l'objet
        $new_imported_file = new SimRequestResponseFile([
            'iccid'                  => $row['icc'],
            'status'                 => $row['status'],
            'status_change_date_str' => $row['statuschangedate'],
            'status_change_date'     => $parsed_date,
        ]);

        // Liaison avec la requête SimRequest
        $new_imported_file->simrequest()->associate($this->simrequest)->save();

        // Incrémentation du compteur de lignes importées
        $this->nb_row_imported++;
        Log::info("Ligne insérée avec succès : " . json_encode($new_imported_file->toArray()));

        return $new_imported_file;
    }

    private function addErrorMessage($msg) {
        if ( count( $this->error_message_arr ) === 0 ) {
            $this->error_message_str = $msg;
        } else {
            $this->error_message_str = $this->error_message_str . " | " . $msg;
        }
        $this->error_message_arr[] = $msg;
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $totalRows = $event->getReader()->getTotalRows();

                foreach ($totalRows as $row) {
                    $this->total_rows = $row;
                }
            }
        ];
    }

    public function prepareForValidation($data, $index)
    {
        $data['icc'] = trim($data['icc'], '-');
        $data['icc'] = trim($data['icc']);

        $data['status'] = trim($data['status'], '-');
        $data['status'] = trim($data['status']);

        $data['statuschangedate'] = trim($data['statuschangedate'], '-');
        $data['statuschangedate'] = trim($data['statuschangedate']);

        return $data;
    }

    public function rules(): array
    {
        return [
            'status' => ['required',],
            'statuschangedate' => ['required',],
            // Can also use callback validation rules
            'icc' => ['required',
                function($attribute, $value, $onFailure) {
                    $sim = Sim::where('iccid', $value)->first();
                    if ( ! $sim ) {
                        $onFailure("ICC '". $value ."' introuvable.");
                    }
                }
            ]
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'icc.required' => 'icc vide.',
            //'icc.exists' => 'icc introuvable.',
            'status.required' => 'status vide.',
            'statuschangedate.required' => 'statuschangedate vide.',
        ];
    }
}
