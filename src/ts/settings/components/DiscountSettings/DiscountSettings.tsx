import React, { ReactNode } from 'react';
import ContextComponent from 'settings/context/ContextComponent';
import Field from 'lib/waui/Field/Field';
import StorefrontCheckbox from 'lib/control/domain/StorefrontCheckbox/StorefrontCheckbox';
import StorefrontInputText from 'lib/control/domain/StorefrontInputText/StorefrontInputText';
import StorefrontSelect from 'lib/control/domain/StorefrontSelect/StorefrontSelect';
import { observer } from 'mobx-react';
import { ISelectOption } from 'lib/waui/Select/Select';

@observer
export default class DiscountSettings extends ContextComponent {
	render(): ReactNode {
		return (
			<div>
				<Field label="Скидки включены">
					<StorefrontCheckbox name="discount.status" />
				</Field>

				<Field label="Размер скидки">
					<StorefrontInputText name="discount.value" type="float" short />{' '}
					<StorefrontSelect options={this.discount_unit_options} name="discount.unit" short />
				</Field>

				<Field
					label="Индивидуальные значения скидки"
					hint="Включает индивидуальные значения размера скидки, зависящие от группы пользователя"
					appendTop
				>
					<StorefrontCheckbox name="discount.individual_status" />
				</Field>

				{this.is_individual_settings && (
					<>
						<Field
							label=""
							hint="Если значение не указано, будет использоваться общее значение размера скидки"
						>
							{this.params.user_groups.map(user_group => (
								<Field label={user_group.name} vertical key={user_group.id}>
									<StorefrontInputText
										name="discount.individual_value"
										type="float"
										arrayAccess={{
											index: user_group.id,
											defaultValue: ''
										}}
										allowEmpty
										short
									/>{' '}
									<StorefrontSelect
										options={this.discount_unit_options}
										name="discount.individual_unit"
										arrayAccess={{
											index: user_group.id,
											defaultValue: this.default_discount_unit
										}}
										short
									/>
								</Field>
							))}
						</Field>
					</>
				)}
			</div>
		);
	}

	get current_currency(): ICurrency {
		return this.params.currencies.find(currency => currency.current);
	}

	get is_individual_settings(): boolean {
		return this.storefront_settings['discount.individual_status'];
	}

	get default_discount_unit(): string {
		return this.storefront_settings['discount.unit'];
	}

	get discount_unit_options(): ISelectOption[] {
		return [
			{
				value: '%',
				label: '%'
			},
			{
				value: this.current_currency.code,
				label: this.current_currency.sign
			}
		];
	}
}
