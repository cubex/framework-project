<?php
namespace Project;

use Cubex\Application\Application;
use Cubex\Context\Context;
use Cubex\Cubex;
use Packaged\Http\Response;
use Project\Controllers\DefaultController;

class DefaultApplication extends Application
{
  protected function _getConditions()
  {
    //Pass off all routing to our default controller
    return new DefaultController();
  }

  public function __construct(Cubex $cubex)
  {
    parent::__construct($cubex);

    //Setup precisions
    ini_set('precision', 14);
    ini_set('serialize_precision', 14);

    // Convert errors into exceptions
    set_error_handler(
      function ($errno, $errstr, $errfile, $errline) {
        if((error_reporting() & $errno) && !($errno & E_NOTICE))
        {
          throw new \ErrorException($errstr, 0, $errno, str_replace(dirname(__DIR__), '', $errfile), $errline);
        }
      }
    );

    //Send debug headers locally
    $cubex->listen(
      Cubex::EVENT_HANDLE_RESPONSE_PREPARE,
      function (Context $c, $response) {
        if($response instanceof Response && $c->isEnv(Context::ENV_LOCAL))
        {
          $response->enableDebugHeaders();
        }
      }
    );
  }
}
