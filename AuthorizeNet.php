<?php
/**
 * The AuthorizeNet PHP SDK. Include this file in your project.
 *
 * @package AuthorizeNet
 */
require dirname(__FILE__) . '/AuthorizeNet/shared/AuthorizeNetRequest.php';
require dirname(__FILE__) . '/AuthorizeNet/shared/AuthorizeNetTypes.php';
require dirname(__FILE__) . '/AuthorizeNet/shared/AuthorizeNetXMLResponse.php';
require dirname(__FILE__) . '/AuthorizeNet/shared/AuthorizeNetResponse.php';
require dirname(__FILE__) . '/AuthorizeNet/AuthorizeNetAIM.php';
require dirname(__FILE__) . '/AuthorizeNet/AuthorizeNetARB.php';
require dirname(__FILE__) . '/AuthorizeNet/AuthorizeNetCIM.php';
require dirname(__FILE__) . '/AuthorizeNet/AuthorizeNetSIM.php';
require dirname(__FILE__) . '/AuthorizeNet/AuthorizeNetDPM.php';
require dirname(__FILE__) . '/AuthorizeNet/AuthorizeNetTD.php';
if (class_exists("SoapClient")) {
    require dirname(__FILE__) . '/AuthorizeNet/AuthorizeNetSOAP.php';
}
/**
 * Exception class for AuthorizeNet PHP SDK.
 *
 * @package AuthorizeNet
 */
class AuthorizeNetException extends Exception
{
}
