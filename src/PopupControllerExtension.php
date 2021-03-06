<?php

namespace AgenceCaza\Popup;

use AgenceCaza\Popup\PopupConfig;

use SilverStripe\Core\Extension;
use SilverStripe\Control\Cookie;

class PopupControllerExtension extends Extension {

	public function PopupConfig() {
		return PopupConfig::get()->first();
	}

	public function PopupTimeStamp() {
		return strtotime(self::PopupConfig()->LastEdited);
	}

	public function Popup() {

		$Popup = self::PopupConfig();

		if ($Popup->Online) {

			if ($Popup->DateTime && !$Popup->DateTimeEnd) {
				if (strtotime($Popup->DateTime) < time() ) { $ActivePopup=$Popup; }
			} else
			if (!$Popup->DateTime && $Popup->DateTimeEnd) {
				if (strtotime($Popup->DateTimeEnd) > time() ) { $ActivePopup=$Popup; }
			} else
			if ($Popup->DateTimeEnd && $Popup->DateTime) {
				if (strtotime($Popup->DateTime) < time() && strtotime($Popup->DateTimeEnd) > time() ) { $ActivePopup=$Popup; }
			} else
			if (!$Popup->DateTime && !$Popup->DateTimeEnd){
				$ActivePopup=$Popup;
			}

			if (($ActivePopup)) {
				if (!(Cookie::get('Popup'))) {
					Cookie::set('Popup', 1, 2400 );
					return true;
				} elseif (Cookie::get('Popup') < strtotime($Popup->DateTimeActive)) {
					return true;
				}

			}  else {
				return false;
			}


		} else {
			return false;
		}

	}


}
