# Installation

composer.json
```json
...
"require": {
  ...
  "mediapark/rekvizitai-api": "dev-master",
},
...
```

```sh
composer update mediapark/rekvizitai-api
```

```php
//AppKernel.php
...
public function registerBundles() {
  $bundles = array(
    ...
    new Mediapark\RekvizitaiBundle\MediaparkRekvizitaiBundle(),
    ...
  );
  ...
}
...
```

# Configuration

```yaml
#parameters.yml
  ...
  rekvizitai_api: 283912839229382190310f08102ehf
  ...
```

Add own company factory class and errors class (must extend RekvizitaiErrors and RekvizitaiCompanyFactory). 
THIS IS OPTIONAL - by default RekvizitaiErrors and RekvizitaiCompanyFactory classes are set.
```yaml
#services.yml
parameters:
  ...
  rekvizitai.company.factory.class: Acme\DemoBundle\OwnCompanyFactoryClass
  rekvizitai.errors_class: Acme\DemoBundle\OwnRekvizitaiErrorsClass
  ...
```

# Usage

```php
//SomeController.php
  ...
  //get rekvizitai service
  $rekvizitai = $this->get('mp.rekvizitai');
  ...

  $rekvizitai->getOneByCode('191315633'); 
  $companies = $rekvizitai->getCompanies(); //returns array of one item
  $company = $rekvizitai->getCompany(); // returns company if found, if not - false
  $result = $rekvizitai->getResult(); // results array

  ...

  $errors = array();
  $result = $rekvizitai->getOneByCode('8293928392', $errors); //$result = company if found, if not - false
  if (!$result) {
    $errorClass = $rekvizitai->getErrorsClass(); // gets error class 
    $errorCode = $errorClass->getCode($rekvizitai->getError()); // gets error code
  }

  ...

  $rekvizitai->getOneByTitle('testas'); // same as by title. ->getAllByTitle also available
  $companies = $rekvizitai->getCompanies();
  $company = $rekvizitai->getCompany();
  $result = $rekvizitai->getResult();

  ...

```

## ERRORS CODES

```php
//error codes
const NO_RESULTS_ERROR = 1;
const TO_MANY_RESULTS_ERROR = 2;
const NO_COMPANY_BY_CODE = 3;
```

