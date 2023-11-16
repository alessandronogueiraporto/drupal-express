<?php

/**
* @file
* Contains \Drupal\push_notification\Form\PushNotificationDeleteForm.
*/

namespace Drupal\push_notification\Form;

use Drupal\Core\Entity\ContentEntityConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Provides a form for deleting a content_entity_example entity.
 *
 * @ingroup push_notification
 */
class PushNotificationDeleteForm extends ContentEntityConfirmFormBase {

	/**
	 * {@inheritdoc}
	 */
	public function getQuestion() {
		return $this->t('Are you sure you want to delete %name?', array('%name' => $this->entity->label()));
	}

	/**
	 * {@inheritdoc}
	 *
	 * If the delete command is canceled, return to the push notification.
	 */
	public function getCancelUrl() {
		return Url::fromRoute('entity.push_notification.edit_form', ['push_notification' =>
		$this->entity->id()]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getConfirmText() {
		return $this->t('Delete');
	}

	/**
	 * {@inheritdoc}
	 *
	 * Delete the entity
	 */
	public function submitForm(array &$form, FormStateInterface $form_state) {
		$entity = $this->getEntity();
		$entity->delete();

		$this->logger('push_notification')->notice('deleted %title.', array('%title' => $this->entity->label(),));

		// Redirect to Push Notification list after delete.
		$form_state->setRedirect('entity.push_notification.collection');
	}
}