<?php

namespace Mediapark\RekvizitaiBundle\Service;

class RekvizitaiErrors {
  const NO_RESULTS_ERROR = 1;
  const TO_MANY_RESULTS_ERROR = 2;
  const NO_COMPANY_BY_CODE = 3;

  private $errors = array(
    self::NO_RESULTS_ERROR => 'Pagal užklausą įmonių nerasta.',
    self::TO_MANY_RESULTS_ERROR => 'Rasta daugiau nei 20 įmonių, susiaurinkite paiešką.',
    self::NO_COMPANY_BY_CODE => 'Neteisingas įmonės kodas.',
  );

  public function __construct() {}

  protected function getErrors() {
    return $this->errors;
  }

  public function getCode($error) {
    foreach ($this->getErrors() as $key => $_error) {
      if ($_error == $error) {
        return $key;
      }
    }

    return false;
  }

}

?>