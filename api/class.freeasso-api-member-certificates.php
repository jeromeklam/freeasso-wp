<?php

/**
 * The member (private access)
 *
 * @author jeromeklam
 */
class Freeasso_Api_Member_Certificates extends Freeasso_Api_Base
{

    /**
     * Behaviour
     */
    use Freeasso_View;
    use Freeasso_User;

    /**
     * Certificates
     * @var []
     */
    protected $certificates = null;

    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct();
        $email = $this->getCurrentUserEmail();
        $this->setMethod(self::FREEASSO_METHOD_GET)->setUrl('/asso/member/' . $email . '/certificates');
        $this->addSortField('rec_ts', self::SORT_DOWN);
        $this->setPrivate();
    }

    /**
     * Get certificates
     *
     * @return array
     */
    public function getCertificates()
    {
        if ($this->certificates === null) {
            $this->getWS();
        }
        return $this->certificates;
    }

    /**
     * Set certificates infos
     *
     * @param array $p_certificates
     *
     * @return Array
     */
    protected function setCertificates($p_certificates)
    {
        $this->certificates = [];
        if ($p_certificates) {
            foreach ($p_certificates as $oneCertificate) {
                $certificate     = new StdClass();
                $certificate->id     = $oneCertificate->rec_id;
                $certificate->cause  = $oneCertificate->cau_name;
                $certificate->date   = $oneCertificate->cert_ts;
                $certificate->mnt    = $oneCertificate->cert_mnt;
                $certificate->money  = $oneCertificate->cert_money;
                $certificate->link   = $oneCertificate->file_id > 0 ? $this->addCurrentUrlParams(
                    [
                        'download_certificate_id' => $oneCertificate->cert_id,
                        'download_name' => 'certificate' . $oneCertificate->cert_id . '.pdf'
                    ]
                ) : null;
                $certificate->file = 'certificate' . $oneCertificate->cert_id . '.pdf';
                //
                $this->certificates[] = $certificate;
            }
        }
        return $this;
    }

    /**
     * Call WS
     *
     * @return boolean
     */
    protected function getWS()
    {
        $result = $this->call();
        if ($result) {
            if (isset($result->data)) {
                $certificates = $result->data;
            } else {
                $certificates = $result;
            }
            $this->setCertificates($certificates);
            return true;
        }
        $this->setCertificates(null);
        return false;
    }
}
