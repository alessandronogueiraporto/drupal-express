<?php

namespace Drupal\chatgpt_plugin\Controller;

use Drupal\content_translation\Controller\ContentTranslationController;
use Drupal\Core\Routing\RouteMatchInterface;

/**
 * Overridden class for entity translation controllers.
 */
class ContentTranslationControllerOverride extends ContentTranslationController {

  /**
   * {@inheritdoc}
   */
  public function overview(RouteMatchInterface $route_match, $entity_type_id = NULL) {
    $build = parent::overview($route_match, $entity_type_id);
    $build = \Drupal::formBuilder()->getForm('Drupal\chatgpt_plugin\Form\ChatGPTTranslateForm', $build);
    return $build;
  }

}
