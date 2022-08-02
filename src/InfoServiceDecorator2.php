<?php
namespace Drupal\resume;

class InfoServiceDecorator2 extends InfoService {

  public function __construct() {
    echo '<p>Сервис декоратор 2: InfoServiceDecorator подключен!</p>';
    parent::__construct();
  }

  public function getRandInfo(): string {
    echo ('<br><p>Сервис декоратор 2: InfoServiceDecorator подключен! (функция)</p>');
    return parent::getRandInfo();
  }
}
