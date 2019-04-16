<?php
namespace Project\Layout;

use Packaged\Ui\Element;

class Layout extends Element
{
  public function time()
  {
    return date("Y-m-d");
  }
}
