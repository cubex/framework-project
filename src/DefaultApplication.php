<?php
namespace Project;

use Cubex\Application\Application;
use Cubex\Context\Context;
use Cubex\Cubex;
use Cubex\Events\Handle\ResponsePrepareEvent;
use Cubex\Http\Handler;
use Packaged\Http\Response;
use Project\Controllers\DefaultController;

class DefaultApplication extends Application
{
  protected function _defaultHandler(): Handler
  {
    return new DefaultController();
  }

  public function __construct(Cubex $cubex)
  {
    parent::__construct($cubex);

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
      ResponsePrepareEvent::class,
      function (ResponsePrepareEvent $e) {
        $r = $e->getResponse();
        if($r instanceof Response && $e->getContext()->isEnv(Context::ENV_LOCAL))
        {
          $r->enableDebugHeaders();
        }
      }
    );
  }
}
