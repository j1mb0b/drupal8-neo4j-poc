<?php
/**
 * @file
 */

namespace Drupal\openfed_neo4j_connector;

use Everyman\Neo4j\Client;
use Everyman\Neo4j\Cypher\Query;

class OpenFedNeo4JDrupalQueryFactory {

  public function create(Client $client, $template, array $vars = array()) {
    return new Query($client, $template, $vars);
  }

}
