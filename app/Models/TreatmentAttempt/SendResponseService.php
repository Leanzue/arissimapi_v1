<?php


namespace App\Models\TreatmentAttempt;


use App\Contrats\ITreatmentService;
use Illuminate\Support\Facades\Http;
use App\Models\SimRequest\SimRequest;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Client\RequestException;

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
    public function execTreatment($treatment): TreatmentResult
    {
        $this->simrequest = $treatment->treatmentattempt->simrequest;
        $this->treatment = $treatment;
        $this->treatmentresult = TreatmentResult::createNewResult($treatment, $this->simrequest, "Envoi Reponse");

        if ( $this->checkInputs() ) {
            try {
                $response = Http::post($this->simrequest->url_response, [
                    'iccid' => $this->simrequest->latestresponsefile->iccid,
                    'status' => $this->simrequest->latestresponsefile->status,
                    'status_change_date' => $this->simrequest->latestresponsefile->status_change_date_str,
                ]);

                $this->treatmentresult->setSuccess();
            } catch (ConnectException $e) {
                $this->treatmentresult->setFailed("status: " . 404 . "; msg: " . $e->getMessage());
            } catch (RequestException $e) {
                $this->treatmentresult->setFailed("status: " . $e->getResponse()->getStatusCode() . "; msg: " . $e->getMessage());
            } catch (\Exception $e) {
                $this->treatmentresult->setFailed($e->getMessage());
            }
        }
        return $this->treatmentresult;
    }

    private function checkInputs() {

        if (! $this->simrequest) {
            $this->treatmentresult->setFailed("Requete non renseigne");
            return false;
        }

        if (! $this->simrequest->url_response) {
            $this->treatmentresult->setFailed("URL Reponse non renseignee");
            return false;
        }

        if (! $this->simrequest->latestresponsefile) {
            $this->treatmentresult->setFailed("Objet FICHIER non existant");
            return false;
        }

        return true;
    }
}
