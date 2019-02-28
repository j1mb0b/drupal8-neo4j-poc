<?php
/**
 * @file
 */

namespace Drupal\openfed_neo4j_connector;

use Everyman\Neo4j\Index\NodeIndex;
use Everyman\Neo4j\Client;

class OpenFedNeo4JDrupalIndexFactory {

  public function create(Client $client, $name, array $config = array()) {
    return new NodeIndex($client, $name, $config);
  }

}
