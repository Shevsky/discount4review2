import React, { ReactNode } from 'react';
import ContextComponent from 'settings/context/ContextComponent';
import Field from 'lib/waui/Field/Field';
import StorefrontCheckbox from 'lib/control/domain/StorefrontCheckbox/StorefrontCheckbox';
import StorefrontInputText from 'lib/control/domain/StorefrontInputText/StorefrontInputText';
import StorefrontSelect from 'lib/control/domain/StorefrontSelect/StorefrontSelect';

export default class DiscountSettings extends ContextComponent {
	render(): ReactNode {
		return (
			<div>
				<Field label="Скидки включены">
					<StorefrontCheckbox name="discount.status" />
				</Field>

				<Field label="Размер скидки">
					<StorefrontInputText name="discount.value" type="float" short />{' '}
					<StorefrontSelect
						options={[
							{
								value: '%',
								label: '%'
							},
							{
								value: this.current_currency.code,
								label: this.current_currency.sign
							}
						]}
						name="discount.unit"
						short
					/>
				</Field>

				<Field
					label="Индивидуальные значения размера скидки"
					hint="Включает индивидуальные значения размера скидки, зависящие от группы пользователя"
				>
					<StorefrontCheckbox name="discount.individual_status" />
				</Field>
			</div>
		);
	}

	get current_currency(): ICurrency {
		return this.params.currencies.find(currency => currency.current);
	}
}
