<?php

namespace Api\V1;

abstract class Api
{
  protected $response_data;
  protected $request_data;
  protected $post_data;
  protected $ch;

  public function __construct()
  {
    $this->ch = curl_init($this->request_data['request_uri']);
  }

  abstract protected function sendResponse();

  abstract protected function sendRequest();

  protected function setHeaders()
  {
      header('Content-Type:application/json');
  }
}
