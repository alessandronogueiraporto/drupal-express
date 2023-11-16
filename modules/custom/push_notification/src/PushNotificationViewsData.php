<?php

namespace Drupal\push_notification;

use Drupal\views\EntityViewsData;

/**
* Provides views data for Push Notification entities.
*
*/
class PushNotificationViewsData extends EntityViewsData {
	/**
	 * Returns the Views data for the entity.
	 */
	public function getViewsData(){
		$data = parent::getViewsData();
		return $data;
	}
}