<?php

// Tested on PHP 5.2, 5.3

// This snippet (and some of the curl code) due to the Facebook SDK.
if (!function_exists('curl_init')) {
  throw new Exception('Stripe needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
  throw new Exception('Stripe needs the JSON PHP extension.');
}


abstract class Stripe
{
  public static $apiKey;
  public static $apiBase = 'https://api.stripe.com/v1';
  public static $verifySslCerts = true;
  const VERSION = '1.6.1';

  public static function getApiKey()
  {
    return self::$apiKey;
  }

  public static function setApiKey($apiKey)
  {
    self::$apiKey = $apiKey;
  }

  public static function getVerifySslCerts() {
    return self::$verifySslCerts;
  }

  public static function setVerifySslCerts($verify) {
    self::$verifySslCerts = $verify;
  }
}


// Utilities
require(TT_LIB . '/stripe/lib/Stripe/Util.php');
require(TT_LIB . '/stripe/lib/Stripe/Util/Set.php');

// Errors
require(TT_LIB . '/stripe/lib/Stripe/Error.php');
require(TT_LIB . '/stripe/lib/Stripe/ApiError.php');
require(TT_LIB . '/stripe/lib/Stripe/ApiConnectionError.php');
require(TT_LIB . '/stripe/lib/Stripe/AuthenticationError.php');
require(TT_LIB . '/stripe/lib/Stripe/CardError.php');
require(TT_LIB . '/stripe/lib/Stripe/InvalidRequestError.php');

// Plumbing
require(TT_LIB . '/stripe/lib/Stripe/Object.php');
require(TT_LIB . '/stripe/lib/Stripe/ApiRequestor.php');
require(TT_LIB . '/stripe/lib/Stripe/ApiResource.php');

// Stripe API Resources
require(TT_LIB . '/stripe/lib/Stripe/Charge.php');
require(TT_LIB . '/stripe/lib/Stripe/Customer.php');
require(TT_LIB . '/stripe/lib/Stripe/Invoice.php');
require(TT_LIB . '/stripe/lib/Stripe/InvoiceItem.php');
require(TT_LIB . '/stripe/lib/Stripe/Plan.php');
require(TT_LIB . '/stripe/lib/Stripe/Token.php');
require(TT_LIB . '/stripe/lib/Stripe/Coupon.php');
require(TT_LIB . '/stripe/lib/Stripe/Event.php');