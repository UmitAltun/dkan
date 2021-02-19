<?php

namespace Drupal\metastore\EventSubscriber;

use Drupal\common\LoggerTrait;
use Drupal\metastore\Events\OrphaningDistribution;
use Drupal\metastore\ResourceMapper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class MapperCleanup.
 */
class MapperCleanup implements EventSubscriberInterface {
  use LoggerTrait;

  /**
   * Inherited.
   *
   * @inheritdoc
   */
  public static function getSubscribedEvents() {
    $events[OrphaningDistribution::EVENT_ORPHANING_DISTRIBUTION][] = ['cleanResourceMapperTable'];
    return $events;
  }

  /**
   * React to a distribution being orphaned.
   *
   * @param \Drupal\metastore\Events\OrphaningDistribution $event
   *   The event object containing the resource uuid.
   */
  public function cleanResourceMapperTable(OrphaningDistribution $event) {
    $id = $event->getUuid();
    // Use the resourceMapper to build a resource object.
    //$resource = $this->resourceMapper->get($id);
    \Drupal::messenger()->addStatus('did it work ' . $id);
    $this->log('dkan', 'Removing resource source mapping.', [], RfcLogLevel::NOTICE);
  }

}
