<?php
namespace Drupal\resume;

/**
 * Info interface
 */
interface Info {
  public function getRandInfo();
}

/**
 * Simple service that return some info ha-ha...
 * @returns string
 */
class InfoService implements Info {
  private array $random_info = [
    "<span>InfoService: That's just a Drupal services</span>",
    "<span>InfoService: Hi, the dev's name is Pavel</span>",
    "<span>InfoService: Lorem ipsum ha-ha-ha</span>",
    "<span>InfoService: Hard for me tho</span>",
    "<span>InfoService: Simple service</span>",
  ];

  /**
   * @inerhitDoc
   */
  public function getRandInfo(): string {
    return $this->random_info[array_rand($this->random_info)];
  }

}

abstract class InfoDecorator implements Info {
  protected InfoService $info;

  // public function __construct(InfoService $info) {
  //   $this->$info = $info;
  // }

  abstract public function getAllInfo();
  abstract public function getSomeInfo(int $num);
}

class TotallyNews extends InfoDecorator {
  protected string $classname = '<p>Totally News:</p>';
  private array $random_infos = [
    "<span>That's just a Drupal services</span>",
    "<span>Hi, the dev's name is Pavel</span>",
    "<span>Lorem ipsum ha-ha-ha</span>",
    "<span>Too hard for me</span>",
    "<span>Simple service</span>",
  ];

  public function getRandInfo(): string {
    return $this->classname . $this->random_infos[array_rand($this->random_infos)];
  }

  public function getAllInfo(): string {
    return $this->classname . join('<span style="color:white !important;">, </span>', $this->random_infos);
  }

  public function getSomeInfo(int $num): string {
    return $this->classname . $this->random_infos[$num] . ' <span style="color:white !important;">['.$num.']</span>';
  }
}
