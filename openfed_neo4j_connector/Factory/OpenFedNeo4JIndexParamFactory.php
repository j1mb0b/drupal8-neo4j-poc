<?php


namespace Drupal\openfed_neo4j_connector\Factory;

use Drupal\openfed_neo4j_connector\OpenFedNeo4JIndexParam;

class OpenFedNeo4JIndexParamFactory {

  /**
   * @var string
   */
  private $namespace;

  /**
   * @var string
   */
  private $key;

  public function __construct($namespace, $key) {
    $this->namespace = $namespace;
    $this->key = $key;
  }

  /**
   * @param $id
   * @return \Drupal\openfed_neo4j_connector\OpenFedNeo4JIndexParam
   */
  public function create($id) {
    return new OpenFedNeo4JIndexParam($this->namespace, $this->key, $id);
  }

}
