<?php
  require "./vendor/autoload.php";

  $data = [];
  $country = $_GET['country'];
  $state = $_GET['state'];
  $filters = ['country' => $country, 'state' => $state];

  foreach(App\Phone::findBy($filters) as $phone)
  {
    $phone_array = [
      'country' => $phone->country,
      'valid'   => $phone->isValid(),
      'code'    => $phone->code,
      'number'  => $phone->number
    ];

    array_push($data, $phone_array);
  }

  echo json_encode($data);
?>
