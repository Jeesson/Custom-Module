<?php
namespace Drupal\resume_core;
use Drupal\resume_interface\InfoInterface;
/**
 * Simple service that return some info ha-ha...
 * @returns string
 */
class InfoService implements InfoInterface {
  private array $random_info = [
    "<span>InfoService: That's just a Drupal services</span>",
    "<span>InfoService: Hi, the dev's name is Pavel</span>",
    "<span>InfoService: Lorem ipsum ha-ha-ha</span>",
    "<span>InfoService: Hard for me tho</span>",
    "<span>InfoService: Simple service</span>",
  ];

  public function __construct()
  {
    return 'Сервис: InfoService подключен!';
  }

  /**
   * @inerhitDoc
   */
  public function getRandInfo(): string {
    return $this->random_info[array_rand($this->random_info)];
  }
}
