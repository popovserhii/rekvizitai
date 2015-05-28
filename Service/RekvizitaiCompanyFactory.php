<?php

namespace Mediapark\RekvizitaiBundle\Service;

use Mediapark\RekvizitaiBundle\Service\RekvizitaiCompany;

class RekvizitaiCompanyFactory implements RekvizitaiCompanyFactoryInterface {
  public function parseFromXML($xml) {
    $company = new RekvizitaiCompany();
    $company->parseFromXML($xml);

    return $company;
  }
}

?>