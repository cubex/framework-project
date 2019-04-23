<?php
namespace Project\Controllers;

use Cubex\Controller\Controller;

class SubController extends Controller
{
  protected function _generateRoutes()
  {
    yield self::_route("", "page");
    // Optionally, you can do:
    // return "page";
  }

  public function getPage()
  {
    return 'Sub Controller Page';
  }
}
