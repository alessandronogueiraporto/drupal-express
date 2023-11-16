<?php

namespace Drupal\push_notification\PLugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Drupal\push_notification\Entity\PushNotification;

/**
 * Provides a Demo Resource
 *
 * @RestResource(
 *   id = "articles",
 *   label = @Translation("Articles listing"),
 *   uri_paths = {
 *     "canonical" = "/get/articles",
 *     "create" = "add/articles"
 *   }
 * )
 */

class GetPushNotification extends ResourceBase {
  
  /**
   * Responds to entity GET requests.
   * @return \Drupal\rest\ResourceResponse
   */
  /*public function get() {
    try {
      $ids = \Drupal::entityQuery('push_notification')->condition('type', 'push_notification')->execute();
      $push =  \Drupal\push_notification\Entity\Node::loadMultiple($ids);
      $response = $this->processNodes($push);
    return new ResourceResponse($response);
    } catch (EntityStorageException $e) {
      \Drupal::logger('custom-rest')->error($e->getMessage());
    }
  }*/

  /**
   * Get push notification
   */
  private function processPushNotification($push_notification) {
    $output = [];
    foreach ($push_notification as $key => $push_notification) {
      $output[$key]['title'] = $node->get('title')->getValue();
      $output[$key]['id'] = $node->get('id')->getValue();
    }
    return $output;
  }

  /**
   * Post api
   */
 public function post($data){
 	
   try {
     $new_term = Term::create([
       'name' => $data['title'],
       'vid' => $data['type'],
     ]);
     
     $new_term->save();

     return new ResourceResponse('Term created successfully in '. $data['type']);

   } catch (EntityStorageException $e) {
     \Drupal::logger('custom-rest')->error($e->getMessage());
   }
 }

}