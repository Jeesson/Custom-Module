<?php
namespace Drupal\resume;

class InfoServiceDecorator extends InfoService {

  public function __construct() {
    parent::__construct();
    echo '<p>Сервис декоратор: InfoServiceDecorator подключен!</p>';
  }

  public function getRandInfo(): string {
    return parent::getRandInfo() . '<br><p>Сервис декоратор: InfoServiceDecorator подключен! (функция)</p>';
  }

}
