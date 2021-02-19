<?php

namespace Drupal\metastore\EventSubscriber;

use Drupal\datastore\Service\ResourceLocalizer;
use Drupal\common\LoggerTrait;
use Drupal\metastore\Events\ResourcePreRemove;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class RemoveLocalResource.
 */
class RemoveLocalResource implements EventSubscriberInterface {
  use LoggerTrait;

  /**
   * Inherited.
   *
   * @inheritdoc
   */
  public static function getSubscribedEvents() {
    $events[ResourcePreRemove::EVENT_RESOURCE_PRE_REMOVE][] = ['deleteLocal'];
    return $events;
  }

  /**
   * Inherited.
   *
   * @inheritdoc
   */
  public function deleteLocal(ResourcePreRemove $event) {
    print_r($event);
    ResourceLocalizer::remove();
    \Drupal::messenger()->addStatus('did we make it?');
    //$this->log('dkan', 'Removing local file.', [], RfcLogLevel::NOTICE);
  }

}
