<?php
/**
 * @file
 * Main controller.
 */

namespace Drupal\openfed_graphdb_web_services\Controller;

use Drupal;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Logger\LoggerChannelTrait;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\openfed_neo4j_connector\OpenFedNeo4JIndexParam;
use Everyman\Neo4j\Node;
use Everyman\Neo4j\Relationship;
use Exception;

class OpenFedGraphdbWebServicesController extends ControllerBase {

  /**
   * @param Drupal\Core\Entity\EntityInterface $entity
   * @return string
   */
  public function initiateNodeCreator(Drupal\Core\Entity\EntityInterface $entity) {
    $id = $entity->id();
    $indexParam = openfed_neo4j_connector_entity_index_factory()->create($id);

    $graphNode = $this->createGraphNode($entity, $indexParam);

    //openfed_neo4j_connector_get_client()->deleteRelationships($indexParam, [], Relationship::DirectionOut);
    //$this->makeRelationships($entity, $graphNode);

    return $graphNode ? $id : NULL;
  }

  /**
   * @param Drupal\Core\Entity\EntityInterface $entity
   * @param OpenFedNeo4JIndexParam $indexParam
   * @return Node
   */
  public function createGraphNode(Drupal\Core\Entity\EntityInterface $entity, OpenFedNeo4JIndexParam $indexParam) {
    $properties = $labels = [];
    foreach(\Drupal::service('entity_field.manager')->getFieldDefinitions('node', $entity->getType()) as $field_name => $field_definition) {
      if ($field_definition->getFieldStorageDefinition()->isBaseField() === TRUE || !($values = $entity->get($field_name)->getString()) || empty($field_definition->getTargetBundle())) continue;

      $labels[] = $field_definition->getLabel();

      $fieldDef = FieldStorageConfig::loadByName($field_definition->getTargetEntityTypeId(), $field_name);

      $properties[$field_name] = $fieldDef && $fieldDef->getCardinality() === 1 ? $values : $values[0];
    }

    if (!empty($properties)) {
      $properties['nid'] = $entity->id();
    }

    return openfed_neo4j_connector_get_client()->updateNode($properties, $labels, $indexParam);
  }

}
