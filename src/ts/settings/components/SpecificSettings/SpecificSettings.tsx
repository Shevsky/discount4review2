import React, { ReactNode } from 'react';
import ContextComponent from 'settings/context/ContextComponent';
import Tabs from 'lib/control/domain/Tabs/Tabs';
import Tab from 'lib/waui/Tab/Tab';
import DiscountSettings from 'settings/components/DiscountSettings/DiscountSettings';
import BonusSettings from 'settings/components/BonusSettings/BonusSettings';
import Icon from 'lib/waui/Icon/Icon';

export default class SpecificSettings extends ContextComponent {
	render(): ReactNode {
		return (
			<div>
				<Tabs id="specific_settings">
					<Tab
						label={
							<>
								<Icon name="ss discounts-bw" /> Скидки
							</>
						}
					>
						<DiscountSettings />
					</Tab>

					<Tab
						label={
							<>
								<Icon name="ss affiliate-bw" /> Бонусы
							</>
						}
					>
						<BonusSettings />
					</Tab>
				</Tabs>
			</div>
		);
	}
}
