<?php

namespace Drupal\site_info\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * NodePageController class.
 */
class NodePageController extends ControllerBase {


  public function render($site_api, $node_id) {

    $config = \Drupal::config('system.site');
    $current_api_key = $config->get('siteapikey');
    if($site_api == 'No API Key yet' || empty($node_id) || $site_api != $current_api_key) {
      return [
        '#type' => 'markup',
        '#markup' => 'access denied',
      ];
    }
    $node_obj = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'page','nid' => $node_id]);
    $serializer = \Drupal::service('serializer');
    $data = $serializer->serialize($node_obj, 'json', ['plugin_id' => 'entity']);

    return new JsonResponse($data);
  }

}