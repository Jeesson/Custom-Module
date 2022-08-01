<?php
namespace Drupal\resume_decorator;
use Drupal\resume_core\InfoService;

class InfoServiceDecorator extends InfoService {

  public function __construct() {
    parent::__construct();
    return 'Сервис декоратор: InfoServiceDecorator подключен!';
  }

}
