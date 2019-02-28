<?php
/**
 * @file
 * Main controller.
 */

namespace Drupal\openfed_neo4j_connector\Controller;

use Drupal;
use Drupal\Core\Controller\ControllerBase;

class OpenFedNeo4JController extends ControllerBase {

  public function adminSettings() {
    try {
      $client = openfed_neo4j_connector_get_client();
      $client->client->getServerInfo();
      drupal_set_message(t('Connection with Neo4J has been established.'));
    }
    catch (\Exception $e) {
      drupal_set_message(t('Cannot connect to the Neo4J database. Please, check the connection details.'), 'warning');
    }

    $settings_form = Drupal::formBuilder()->getForm('Drupal\openfed_neo4j_connector\Form\OpenFedNeo4JAdminForm');
    return $settings_form;
  }

}
