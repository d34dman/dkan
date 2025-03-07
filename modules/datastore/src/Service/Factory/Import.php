<?php

namespace Drupal\datastore\Service\Factory;

use Drupal\datastore\Storage\DatabaseTableFactory;
use Drupal\datastore\Service\Import as Instance;
use Drupal\common\Storage\JobStoreFactory;

/**
 * Create an importer object for a given resource.
 */
class Import implements ImportFactoryInterface {

  /**
   * Job store factory.
   *
   * @var \Drupal\common\Storage\JobStoreFactory
   */
  private $jobStoreFactory;

  /**
   * Database table factory.
   *
   * @var \Drupal\datastore\Storage\DatabaseTableFactory
   */
  private $databaseTableFactory;

  /**
   * Import services.
   *
   * @var \Drupal\datastore\Service\Import[]
   */
  private $services = [];

  /**
   * Constructor.
   */
  public function __construct(JobStoreFactory $jobStoreFactory, DatabaseTableFactory $databaseTableFactory) {
    $this->jobStoreFactory = $jobStoreFactory;
    $this->databaseTableFactory = $databaseTableFactory;
  }

  /**
   * Inherited.
   *
   * @inheritdoc
   */
  public function getInstance(string $identifier, array $config = []) {

    if (!isset($config['resource'])) {
      throw new \Exception("config['resource'] is required");
    }

    $resource = $config['resource'];

    if (!isset($this->services[$identifier])) {
      $this->services[$identifier] = new Instance($resource, $this->jobStoreFactory, $this->databaseTableFactory);
    }

    return $this->services[$identifier];
  }

}
