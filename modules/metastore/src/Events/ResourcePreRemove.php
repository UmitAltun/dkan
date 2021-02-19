<?php

namespace Drupal\metastore\Events;

use Symfony\Component\EventDispatcher\Event;

/**
 * Initiate database clean up when a distribution is orphaned.
 *
 * @package Drupal\metastore\Events
 */
class ResourcePreRemove extends Event {
  /**
   * Event fired when a local file is about to be deleted.
   *
   * @Event
   */
  const EVENT_RESOURCE_PRE_REMOVE = 'metastore.resource_pre_remove';
  private $uuid;

  /**
   * Constructor.
   */
  public function __construct(Uuid $uuid) {
    $this->uuid = $uuid;
  }

  /**
   * Getter.
   */
  public function getUuid(): Uuid {
    return $this->uuid;
  }

}
