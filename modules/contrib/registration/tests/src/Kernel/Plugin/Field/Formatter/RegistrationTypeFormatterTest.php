<?php

namespace Drupal\Tests\registration\Kernel\Plugin\Field\Formatter;

use Drupal\Tests\registration\Traits\NodeCreationTrait;

/**
 * Tests the registration_type formatter.
 *
 * @coversDefaultClass \Drupal\registration\Plugin\Field\FieldFormatter\RegistrationTypeFormatter
 *
 * @group registration
 */
class RegistrationTypeFormatterTest extends FormatterTestBase {

  use NodeCreationTrait;

  /**
   * @covers ::render
   */
  public function testRegistrationTypeFormatter() {
    $node = $this->createAndSaveNode();
    $build = $node->get('event_registration')->view([
      'type' => 'registration_type',
      'label' => 'hidden',
    ]);
    $output = $this->renderPlain($build);
    $this->assertEquals('Conference', $output);
  }

}
