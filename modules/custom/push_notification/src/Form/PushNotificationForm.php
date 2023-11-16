<?php

/**
* @file
* Contains Drupal\push_notification\Form\PushNotificationForm.
*/

namespace Drupal\push_notification\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
* Form controller for the Push Notification entity edit forms.
*
* @ingroup content_entity_example
*/

class PushNotificationForm extends ContentEntityForm {

	/**
	* {@inheritdoc}
	*/
	public function buildForm(array $form, FormStateInterface $form_state) {
		/* @var $entity \Drupal\push_notification\Entity\PushNotification */
		$form = parent::buildForm($form, $form_state);
		return $form;
	}

	/**
	* {@inheritdoc}
	*/
	public function save(array $form, FormStateInterface $form_state) {
		// Redirect to Push Notification list after save.
		//$form_state->setRedirect('entity.push_notification.collection');
		$form_state->setRedirect('<front>');
		$entity = $this->getEntity();
		$entity->save();
	}
}