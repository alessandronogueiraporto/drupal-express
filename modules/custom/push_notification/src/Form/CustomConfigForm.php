<?php

namespace Drupal\push_notification\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class CustomConfigForm.
 */

class CustomConfigForm extends ConfigFormBase {

	/**
	 * {@inheritdoc}
	 */

	protected function getEditableConfigNames() {
		return [
			'push_notification.customconfig',
		];
	}

	/**
	 * {@inheritdoc}
	 */

	public function getFormId() {
		return 'custom_config_form';
	}

	/**
	 * {@inheritdoc}
	 */

	public function buildForm(array $form, FormStateInterface $form_state) {
		$config = $this->config('push_notification.customconfig');
		$form['endpoint'] = array(
			'#type' => 'details',
			'#title' => $this->t('Endpoint'),
			'#open' => TRUE,
		);

		$form['endpoint']['endpointurl'] = [
			'#type' => 'textarea',
			'#title' => $this->t('Endpoint URL'),
			'#default_value' => $config->get('endpointurl'),
			'#maxlength' => NULL,
		];

		return parent::buildForm($form, $form_state);
	}

	/**
	* {@inheritdoc}
	*/

	public function submitForm(array &$form, FormStateInterface	$form_state) {
		parent::submitForm($form, $form_state);
		$this->config('push_notification.customconfig')
		->set('endpointurl', $form_state->getValue('endpointurl'))
		->save();
	}		
}