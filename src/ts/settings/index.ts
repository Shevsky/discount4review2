import './declares';
import Settings from 'settings/classes/Settings';

declare global {
	interface Window {
		shop_discount4review_settings: typeof Settings;
	}
}

window.shop_discount4review_settings = Settings;
