<?php
namespace Drupal\resume;

class InfoServiceDecorator2 extends InfoService {

  public function __construct() {
    parent::__construct();
    echo '<p>Сервис декоратор 2: InfoServiceDecorator подключен!</p>';
  }

  public function getRandInfo(): string {
    return parent::getRandInfo() . '<br><p>Сервис декоратор 2: InfoServiceDecorator подключен! (функция)</p>';
  }
}
