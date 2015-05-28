<?php

namespace Mediapark\RekvizitaiBundle\Service;

class RekvizitaiCompany {
  private $title;
  private $code;
  private $address;
  private $city;
  private $street;
  private $houseNo;
  private $addressRest;
  private $categories;
  private $phone;
  private $mobile;
  private $fax;
  private $website;
  private $email;
  private $pvmCode;
  private $url;
  private $postCode;

  public function __construct() {}

  public function parseFromXML($xml) {
    foreach ($xml->children() as $key => $child) {
      $this->{$key} = (string)$child;
    }
    return $this;
  }

  public function getAddress()
  {
      return $this->address;
  }

  public function getCity()
  {
      return $this->city;
  }

  public function getStreet()
  {
      return $this->street;
  }

  public function getHouseNo()
  {
      return $this->houseNo;
  }

  public function getAddressRest()
  {
      return $this->addressRest;
  }

  public function getCategories()
  {
      return $this->categories;
  }

  public function getPhone()
  {
      return $this->phone;
  }

  public function getMobile()
  {
      return $this->mobile;
  }

  public function getFax()
  {
      return $this->fax;
  }

  public function getWebsite()
  {
    return $this->website;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function getVATCode()
  {
    return $this->pvmCode;
  }

  public function getPostCode() {
    return $this->postCode;
  }

  public function getCode() {
    return $this->code;
  }

  public function getTitle() {
    return $this->title;
  }
}

?>
