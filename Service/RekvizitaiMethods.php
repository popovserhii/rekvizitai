<?php

namespace Mediapark\RekvizitaiBundle\Service;

class RekvizitaiMethods {
  protected $methods = array(
    'search' => 'search&query=:query',
    'companyDetails' => 'companyDetails&code=:code',
  );

  public function __construct() {}

  public function generateByMethod($method, $params) {
    if (!$this->methodExists($method)) {
      return false;
    }

    $generated = $this->generate($method, $params);
    return $generated;
  }

  protected function generate($method, $params) {
    $method = $this->getMethod($method);
    $generated = $method;
    foreach ($params as $key => $param) {
      $generated = str_replace($key, $param, $generated);
    }

    return $generated;
  }

  public function methodExists($method) {
    return isset($this->methods[$method]);
  }

  public function getMethod($method) {
    if (!$this->methodExists($method)) {
      return false;
    }

    return $this->methods[$method];
  }
}

?>