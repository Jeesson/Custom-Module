<?php
namespace Drupal\resume;

class InfoServiceDecorator extends InfoService {

  public function __construct() {
    echo '<p>Сервис декоратор 1: InfoServiceDecorator подключен!</p>';
    parent::__construct();
  }

  public function getRandInfo(): string {
    echo ('<br><p>Сервис декоратор 1: InfoServiceDecorator подключен! (функция)</p>');
    return parent::getRandInfo();
  }
}
