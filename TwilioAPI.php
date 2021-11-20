<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;

class Twilio {

  protected $CI;

  public function __construct() {
    $this->CI = &get_instance();

    //Get Twilio API credentials
    $this->twilio_account_sid = $this->CI->config->item('twilio_account_sid');
    $this->twilio_auth_token = $this->CI->config->item('twilio_auth_token');
    $this->twilio_phone_number = $this->CI->config->item('twilio_phone_number');
    
    require_once 'application/third_party/Twilio/autoload.php';
  }

  public function SendSms($phone = NULL, $token = NULL)
  { 
    $client = new Client($this->twilio_account_sid, $this->twilio_auth_token);
    try {
      $body = sprintf('This is your Gathr venmo verification code: %s', $token);
      $message = $client->messages->create(
          $phone,
          [
              "body" => $body,
              "from" => $this->twilio_phone_number
          ]
      );
      
      return $phone;

    } catch (TwilioException $e) {
      $error_msg = "Error [ ".$e->getCode()." ] ".$e->getMessage();
      return "failure:".$error_msg;
    } 
  }

  public function SendSmsToPhone($phone = NULL, $body = NULL)
  { 
    $client = new Client($this->twilio_account_sid, $this->twilio_auth_token);
    try {
      $message = $client->messages->create(
          $phone,
          [
              "body" => $body,
              "from" => $this->twilio_phone_number
          ]
      );
      
      return $phone;

    } catch (TwilioException $e) {
      $error_msg = "Error [ ".$e->getCode()." ] ".$e->getMessage();
      return "failure:".$error_msg;
    } 
  }
}
