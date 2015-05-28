<?php

namespace Mediapark\RekvizitaiBundle\Service;

class RekvizitaiURL {
  const URL_BASE = 'http://www.rekvizitai.lt/api-xml/';
  const API_KEY_QUERY = '?apiKey=';
  const SEARCH_QUERY = '&clientId=1&method=';

  private $base;

  public function __construct($base = self::URL_BASE) {
    $this->setBase($base);
  }

  public function setBase($base) {
    $this->base = $base;
  }

  public function getBase() { 
    return $this->base;
  }

  public function generateURL($key, $query) {
    return $this->getBase() . $this->generateAPIKeyQuery($key) . $this->generateSearchQuery($query);
  }

  public function generateAPIKeyQuery($key) {
    return self::API_KEY_QUERY . $key;
  }

  public function generateSearchQuery($query) {
    return self::SEARCH_QUERY . $query;
  }
}

?>