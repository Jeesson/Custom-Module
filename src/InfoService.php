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
    "InfoService: That's just a Drupal services",
    "InfoService: Hi, the dev's name is Pavel",
    "InfoService: Lorem ipsum ha-ha-ha",
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
  ];

  public function getRandInfo(): string {
    // TODO: Implement getRandInfo() method.
    return $this->classname . $this->random_infos[array_rand($this->random_infos)];
  }

  public function getAllInfo() {
    // TODO: Implement getAllInfo() method.
    echo $this->classname . implode(', ', $this->random_infos);
  }

  public function getSomeInfo(int $num): string {
    // TODO: Implement getSomeInfo() method.
    return $this->random_infos[$num];
  }
}
