<?php


namespace App\Models\Treatment;


use Illuminate\Support\Facades\Http;
use App\Models\SimRequest\SimRequest;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Client\RequestException;
use App\Contrats\Treatment\ITreatmentService;

class SendResponseService implements ITreatmentService
{

    /**
     * @var SimRequest
     */
    public $simrequest;

    /**
     * @var Treatment
     */
    public $treatment;

    /**
     * @var TreatmentResult
     */
    public $treatmentresult;

    public static function getQueueName()
    {
        return "sendresponseservice";
    }

    /**
     * @param Treatment $treatment
     * @return TreatmentResult
     */
    public function execService($treatment): TreatmentResult
    {
        $this->simrequest = $treatment->uppertreatment->uppertreatment;
        $this->treatment = $treatment;
        $this->treatmentresult = TreatmentResult::createNewResult($treatment, $this->simrequest, "Envoi Reponse");

        if ( $this->checkRequiredInputs() ) {
            try {
                $response = Http::post($this->simrequest->url_response, [
                    'iccid' => $this->simrequest->latestresponsefile->iccid,
                    'status' => $this->simrequest->latestresponsefile->status,
                    'status_change_date' => $this->simrequest->latestresponsefile->status_change_date_str,
                ]);

                $this->treatment->endTreatmentWithSuccess();
            } catch (ConnectException $e) {
                $this->treatment->endTreatmentWithFailure("status: " . 404 . "; msg: " . $e->getMessage());
            } catch (RequestException $e) {
                $this->treatment->endTreatmentWithFailure("status: " . $e->getResponse()->getStatusCode() . "; msg: " . $e->getMessage());
            } catch (\Exception $e) {
                $this->treatment->endTreatmentWithFailure($e->getMessage());
            }
        }
        return $this->treatmentresult;
    }

    private function checkRequiredInputs() {

        if (! $this->simrequest) {
            $this->treatment->endTreatmentWithFailure("Requete non renseigne");
            return false;
        }

        if (! $this->simrequest->url_response) {
            $this->treatment->endTreatmentWithFailure("URL Reponse non renseignee");
            return false;
        }

        if (! $this->simrequest->latestresponsefile) {
            $this->treatment->endTreatmentWithFailure("Objet FICHIER non existant");
            return false;
        }

        return true;
    }
}
