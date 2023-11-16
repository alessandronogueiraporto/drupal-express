<?php
/**
 * @file
 * Contains \Drupal\push_notification\Entity\PushNotification.
 */

namespace Drupal\push_notification\Entity;

use Drupal\Core\Entity\EditorialContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityStorageInterface;

/**
 * Defines the push_notification entity.
 *
 * @ingroup push_notification
 *
 * @ContentEntityType(
 *   id = "push_notification",
 *   label = @Translation("Push Notification"),
 *   base_table = "push_notification",
 *   data_table = "push_notification_field_data",
 *   revision_table = "push_notification_revision",
 *   revision_data_table = "push_notification_field_revision",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "label" = "title",
 *     "revision" = "vid",
 *     "status" = "status",
 *     "published" = "status",
 *     "uid" = "uid",
 *     "owner" = "uid",
 *   },
 *   revision_metadata_keys = {
 *     "revision_user" = "revision_uid",
 *     "revision_created" = "revision_timestamp",
 *     "revision_log_message" = "revision_log"
 *   },
 *   handlers = {
 *     "access" = "Drupal\push_notification\PushNotificationAccessControlHandler",
 *     "views_data" = "Drupal\push_notification\PushNotificationViewsData",
 *     "form" = {
 *       "add" = "Drupal\push_notification\Form\PushNotificationForm",
 *       "edit" = "Drupal\push_notification\Form\PushNotificationForm",
 *       "delete" = "Drupal\push_notification\Form\PushNotificationDeleteForm",
 *     },
 *   },
 *   links = {
 *     "canonical" = "/push_notification/{push_notification}",
 *     "delete-form" = "/push_notification/{push_notification}/delete",
 *     "edit-form" = "/push_notification/{push_notification}/edit",
 *     "create" = "/push_notification/create",
 *   },
 * )
 */

class PushNotification extends EditorialContentEntityBase {

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type); // provides id and uuid fields

    $fields['user_id'] = BaseFieldDefinition::create(type: 'entity_reference')
      ->setLabel(t(string: 'User'))
      ->setDescription(t(string: 'The user that created the push_notification.'))
      ->setSetting(setting_name: 'target_type', value: 'user')
      ->setSetting(setting_name: 'handler', value: 'default')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setDescription(t('The title of the push_notification'))
      ->setSettings([
        'max_length' => 150,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['message'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Message'))
      ->setRequired(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'string_textarea',
        'weight' => 4,
        'settings' => [
          'rows' => 6,
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'string',
        'weight' => 0,
        'label' => 'above',
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Push Notification entity is published.'))
      ->setDefaultValue(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

  /**
   * {@inheritdoc}
   * 
   * Make the current user the owner of the entity
   */
   public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
    );
   }

   /**
   * {@inheritdoc}
   */
   public function getOwner() {
    return $this->get('user_id')->entity;
   }

   /**
   * {@inheritdoc}
   */
   public function getOwnerId() {
    return $this->get('user_id')->target_id;
   }

}