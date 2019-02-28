<?php
/**
 */

namespace Drupal\openfed_neo4j_connector\Form;

use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class OpenFedNeo4JAdminForm extends ConfigFormBase {

  public function __construct(ConfigFactory $config_factory) {
    parent::__construct($config_factory);
  }

  public function getFormId() {
    return 'openfed_neo4j_connector_admin_settings';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $settings = $this->configFactory->get('openfed_neo4j_connector.site');

    $form['host'] = array(
      '#title' => t('Server host'),
      '#type' => 'textfield',
      '#default_value' => $settings->get('host'),
      '#description' => t('Default host of the Neo4J server. Default is localhost. For authentication add the credentials to the domain: &lt;username&gt;:&lt;password&gt;@&lt;domain&gt;.'),
    );

    $form['port'] = array(
      '#title' => t('Server port'),
      '#type' => 'textfield',
      '#default_value' => $settings->get('port'),
      '#description' => t('Port for the Neo4J server. Default is 7474.'),
    );

    $form['username'] = array(
      '#title' => t('Server username'),
      '#type' => 'textfield',
      '#default_value' => $settings->get('username'),
      '#description' => t('Username.'),
    );

    $form['password'] = array(
      '#title' => t('Server password'),
      '#type' => 'password',
      '#default_value' => $settings->get('password'),
      '#description' => t('User password.'),
    );

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $hostname = $form_state->getValue('host');
    $username = $form_state->getValue('username');
    $password = $form_state->getValue('password');
    $host = ($username && $password) ? $username . ':' . $password . '@' . $hostname : $hostname;
    $this->configFactory->getEditable('openfed_neo4j_connector.site')
      ->set('host', $host)
      ->set('port', $form_state->getValue('port'))
      ->save();

    parent::submitForm($form, $form_state);
  }

  /**
   * Gets the configuration names that will be editable.
   *
   * @return array
   *   An array of configuration object names that are editable if called in
   *   conjunction with the trait's config() method.
   */
  protected function getEditableConfigNames() {
    return ['openfed_neo4j_connector.site'];
  }

}
