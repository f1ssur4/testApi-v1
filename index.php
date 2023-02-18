<?php

use api\V1\SaleApi;


require_once 'Api/V1/SaleApi.php';

  try {
    $api = new SaleApi($_POST);
    echo $api->send();
  } catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
  }

