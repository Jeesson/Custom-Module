<?php
namespace Drupal\resume;
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

  public function __construct() {
    echo '<p>Сервис: InfoService подключен!</p>';
  }

  /**
   * @inerhitDoc
   */
  public function getRandInfo(): string {
    return $this->random_info[array_rand($this->random_info)];
  }
}
