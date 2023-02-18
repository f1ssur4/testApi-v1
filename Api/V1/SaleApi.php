<?php

namespace Api\V1;

require_once 'Api/V1/Api.php';

class SaleApi extends Api
{
  public function __construct(array $post_data)
  {
    $this->post_data = $post_data;
    $this->processingPostData();
    parent::__construct();
  }

  public function send()
  {
    curl_setopt($this->ch, CURLOPT_POST, 1);
    curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($this->request_data['data']));
    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

    $this->sendRequest();
    curl_close($this->ch);

    $this->setHeaders();

    return $this->sendResponse();
  }

  public function sendRequest()
  {
    $this->response_data = curl_exec($this->ch);
  }

  public function sendResponse()
  {
    return $this->response_data;
  }

  private function getSpecialPasswordHash()
  {
    return md5(strtoupper(strrev($this->post_data['payer_email']) . $this->post_data['client_pass'] . strrev(substr($this->post_data['card_number'],0,6).substr($this->post_data['card_number'],-4))));
  }

  private function processingPostData()
  {
    if (!empty($this->post_data)){
      foreach ($this->post_data as $key => $post_datum) {
        if ($key === 'request_uri'){
          $this->request_data['request_uri'] = $post_datum;
        }elseif ($key === 'client_pass'){
          $this->request_data['data']['hash'] = $this->getSpecialPasswordHash();
        }else{
          $this->request_data['data'][$key] = $post_datum;
        }
      }
    }
  }
}
