<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ltic {

  private $launch_url = '';
  private $key = '';
  private $secret = '';
  private $launch_data = array();

  public function __construct($data = array())
  {
    $this->setLaunchUrl($data['launch_url']);
    $this->setKey($data['key']);
    $this->setSecret($data['secret']);
    $this->launch_data = array(
      "lti_version" => "LTI-1p0",
      "lti_message_type" => "basic-lti-launch-request",
      "oauth_callback" => "about:blank",
      "oauth_version" => "1.0",
      "oauth_nonce" => uniqid('', true),
      "oauth_signature_method" => "HMAC-SHA1"
    );
  }

  public function setLaunchUrl($launch_url)
  {
    $this->launch_url = $launch_url;
  }

  public function getLaunchUrl()
  {
    return $this->launch_url;
  }

  public function setKey($key)
  {
    $this->key = $key;
  }

  public function getKey()
  {
    return $this->key;
  }

  public function setSecret($secret)
  {
    $this->secret = $secret;
  }

  public function getSecret()
  {
    return $this->secret;
  }

  public function setLaunchData($data = array())
  {
    foreach($data as $key => $value)
    {
      $this->launch_data[$key] = $value;
    }
  }

  public function getLaunchData()
  {
    return $this->launch_data;
  }

  private function checkData(){
    if($this->launch_url && $this->key && $this->secret)
    {
      return true;
    }
    return false;
  }

  public function createSignature()
  {
    if(!$this->checkData())
    {
      return false;
    }

    //Add final config values
    $now = new DateTime();
    $this->launch_data['oauth_timestamp'] = $now->getTimeStamp();
    $this->launch_data['oauth_consumer_key'] = $this->key;

    //OAuth requires values to be put in order
    $launch_data_keys = array_keys($this->launch_data);
    sort($launch_data_keys);
    $launch_params = array();
    foreach ($launch_data_keys as $key)
    {
      array_push($launch_params, $key . "=" . rawurlencode($this->launch_data[$key]));
    }

    //Build the request
    $base_string = "POST&" . urlencode($this->launch_url) . "&" . rawurlencode(implode("&", $launch_params));
    $secret = urlencode($this->secret) . "&";
    $signature = base64_encode(hash_hmac("sha1", $base_string, $this->secret, true));

    return $signature;
  }

  public function debug()
  {
    print '<pre>';
    var_dump($this->launch_url, $this->key, $this->secret, $this->launch_data);
    print '</pre>';
    exit();
  }

}
