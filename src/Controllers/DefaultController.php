<?php
namespace Project\Controllers;

use Cubex\Controller\Controller;
use Packaged\Helpers\Strings;
use Project\Layout\Layout;

class DefaultController extends Controller
{
  protected function _getConditions()
  {
    yield self::_route("/hello/world", SubController::class);
    yield self::_route("/hello/{who}", "hello");
    yield self::_route("/hello", "layout");
    yield self::_route("/", "homepage");
  }

  public function getLayout()
  {
    return new Layout();
  }

  public function getHello()
  {
    return "Hello " . Strings::titleize($this->getContext()->routeData()->getAlpha('who'));
  }

  public function getHomepage()
  {
    echo "Homepage";
  }
}
