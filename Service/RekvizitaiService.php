<?php

namespace Mediapark\RekvizitaiBundle\Service;

use Mediapark\RekvizitaiBundle\Service\RekvizitaiErrors;
use Mediapark\RekvizitaiBundle\Service\RekvizitaiCompanyFactory;
use Mediapark\RekvizitaiBundle\Service\RekvizitaiURL;
use Mediapark\RekvizitaiBundle\Service\RekvizitaiMethods;

class RekvizitaiService {
  const STATUS_SUCCESS = 'success';
  const STATUS_ERROR = 'error';

  protected $key;
  protected $result;
  protected $url;
  protected $methods;
  protected $companyFactory;
  protected $errorsClass;

  public function __construct($key, $companyFactory = null, $errorsClass = null, $methods = null, $url = null) {
    $this->setKey($key);
    $this->setUrl($url);
    $this->setMethods($methods);
    $this->setCompanyFactory($companyFactory);
    $this->setErrorsClass($errorsClass);
  }

  public function setErrorsClass($errorsClass = null) {
    if (is_null($errorsClass)) {
      $errorsClass = new RekvizitaiErrors();
    }

    $this->errorsClass = new $errorsClass();
  }

  public function getErrorsClass() {
    return $this->errorsClass;
  }

  public function setCompanyFactory($companyFactory = null) {
    if (is_null($companyFactory)) {
      $companyFactory = new RekvizitaiCompanyFactory();
    }

    $this->companyFactory = new $companyFactory;
  }

  public function getCompanyFactory() {
    return $this->companyFactory;
  }

  public function setUrl($url = null) {
    if (is_null($url)) {
      $url = new RekvizitaiURL();
    }
    $this->url = $url;
  }

  public function setMethods($methods = null) {
    if (is_null($methods)) {
      $methods = new RekvizitaiMethods();
    }

    $this->methods = $methods;
  }

  public function setKey($key) {
    $this->key = $key;
  }

  public function getKey() {
    return $this->key;
  }

  public function getMethods() {
    return $this->methods;
  }

  protected function setResult($result) {
    $this->result = $result;
  }

  public function getResult() {
    return $this->result;
  }

  public function getUrl() {
    return $this->url;
  }

  public function resultExists() {
    return !is_null($this->getResult());
  }

  public function getOneByTitle($title, array &$result = null) {
    $this->getByTitle($title);
    $this->handleError($result);
    return $this->getCompany();
  }

  public function getAllByTitle($title, array &$result = null) {
    $this->getByTitle($title);
    $this->handleError($result);
    return $this->getCompanies();
  }

  protected function getByTitle($title) {
    $url = $this->getUrl()->generateURL($this->getKey(), $this->getMethods()->generateByMethod('search', array(':query' => $title)));

    $xml = simplexml_load_file($url);

    $this->setResult($xml);
    return $this->getResult();
  }

  protected function checkResult() {
    if (!$this->resultExists()) {
      throw new \Exception('REKVIZITAI SERVICE: No result. Fetch firstly.');
    }

    return $this->getResult();
  }

  public function getStatus() {
    $this->checkResult();
    return $this->getResult()->status;
  }

  public function isOk() {
    $this->checkResult();
    return $this->getStatus() == self::STATUS_SUCCESS;
  }

  public function isError() {
    $this->checkResult();
    return $this->getStatus() == self::STATUS_ERROR;
  }

  public function countCompanies() {
    $result = $this->checkResult();
    $companies = $result->companies;
    $noCompanies = !isset($result->companies);
    if ($noCompanies) {
      return 0;
    }
    else {
      return count($companies->company);
    } 
  }

  public function getCompany() {
    $count = $this->countCompanies();
    if ($count > 1 || $count == 0 || !$this->isOk()) {
      return false;
    }
    else {
      $company = $this->getResult()->companies->company;
      return $this->companyFromXML($company);
    }
  }

  public function getCompanies() {
    $count = $this->countCompanies();
    if (!$this->isOk()) return false;
    return $this->companiesFromXML($this->getResult()->companies);
  }

  protected function companiesFromXML($xml) {
    $companies = array();
    foreach ($xml->children() as $company) {
      $companies[] = $this->companyFromXML($company);
    }
    return $companies;
  }

  public function companyFromXML($xml) {
    return $this->getCompanyFactory()->parseFromXML($xml);
  }

  public function getOneByCode($code, array &$result = null) {
    $this->getByCode($code);
    $this->handleError($result);
    return ($this->isError()) ? false : $this->getCompany();
  }

  public function getAllByCode($code, array &$result = null) {
    $this->getByCode($code);
    $this->handleError($result);
    return ($this->isError()) ? false : $this->getCompanies();
  }

  protected function getByCode($code) {
    $url = $this->getUrl()->generateURL($this->getKey(), $this->getMethods()->generateByMethod('companyDetails', array(':code' => $code)));

    $xml = simplexml_load_file($url);

    $this->setResult($xml);
  }

  public function getError() {
    $this->checkResult();
    return $this->getResult()->error;
  }

  protected function handleError(&$result) {
    if ($this->isError()) {
      $result['status'] = $this->getStatus();
      $result['error'] = $this->getError();
    }

    return $result;
  }

}