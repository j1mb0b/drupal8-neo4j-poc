<?php
/**
 * @file
 */

namespace Drupal\openfed_neo4j_connector;

use Everyman\Neo4j\Client;

/**
 * Class OpenFedNeo4JDrupalLibraryFactory
 * @package Drupal\openfed_neo4j_connector
 */
class OpenFedNeo4JDrupalLibraryFactory {

  /**
   * @return \Everyman\Neo4j\Client
   */
  public function create() {
    $config = \Drupal::config('openfed_neo4j_connector.site');
    return new Client($config->get('host'), $config->get('port'));
  }

}
