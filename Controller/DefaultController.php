<?php

namespace Mediapark\RekvizitaiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
      $rekvizitai = $this->get('mp.rekvizitai');

      $rekvizitai->getOneByCode('191315633');
      $companies = $rekvizitai->getCompanies();
      $company = $rekvizitai->getCompany();
      $result = $rekvizitai->getResult();

      var_dump($companies);
      var_dump($company);
      var_dump($result);

      var_dump('--------------');

      $errors = array();
      $result = $rekvizitai->getOneByCode('8293928392', $errors);
      if (!$result) {
        var_dump($rekvizitai->getError());
        $errorClass = $rekvizitai->getErrorsClass();
        $errorCode = $errorClass->getCode($rekvizitai->getError());
        var_dump($errorCode);
      }

      var_dump('--------------');

      $rekvizitai->getOneByTitle('testas');
      $companies = $rekvizitai->getCompanies();
      $company = $rekvizitai->getCompany();
      $result = $rekvizitai->getResult();

      var_dump($companies);
      var_dump($company);
      var_dump($result);

      var_dump('--------------');

      return array('test');
    }
}
