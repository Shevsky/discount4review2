import React, { ReactNode } from 'react';
import ContextComponent from 'settings/context/ContextComponent';
import SettingsModelIdSelect from 'settings/components/SettingsModelIdSelect/SettingsModelIdSelect';
import FieldGroup from 'lib/waui/FieldGroup/FieldGroup';
import Field from 'lib/waui/Field/Field';
import StorefrontCheckbox from 'lib/control/domain/StorefrontCheckbox/StorefrontCheckbox';
import StorefrontDatepicker from 'lib/control/domain/StorefrontDatepicker/StorefrontDatepicker';
import StorefrontInputText from 'lib/control/domain/StorefrontInputText/StorefrontInputText';

export default class CommonSettings extends ContextComponent {
	render(): ReactNode {
		return (
			<div>
				<SettingsModelIdSelect model={this.storefront_settings} />

				<FieldGroup title="Параметры заказов, для которых действительно предложение">
					<Field
						label="Заказ обработан не ранее"
						hint="Покупатель сможет воспользоваться предложением получения скидки за отзывы только за те заказы, которые были обработаны или выполнены после указанной даты. Это может пригодиться, если Вы не хотите, чтобы покупатели поднимали слишком старые заказы и получали по ним скидки."
					>
						<StorefrontDatepicker name="orders_availability.from_date" />
					</Field>

					<Field label="Статус заказа">
						{this.params.states.map(state => (
							<StorefrontCheckbox
								name="orders_availability.state_ids"
								arrayAccess={{
									index: state.id,
									defaultValue: false
								}}
								key={state.id}
							>
								{state.name}
							</StorefrontCheckbox>
						))}
					</Field>

					<Field
						label="Только для последнего заказа"
						hint="Воспользоваться предложением можно только по последнему ОБРАБОТАННОМУ заказу.
Ранее полученные купоны/начисленные бонусы при этом не удаляются"
					>
						<StorefrontCheckbox name="orders_availability.is_for_latest" />
					</Field>

					<Field label="Товаров в заказе от...">
						<StorefrontInputText name="orders_availability.products_min_count" type="int" middle />{' '}
						шт.
					</Field>

					<Field label="Сумма заказа от...">
						<StorefrontInputText name="orders_availability.order_sum_min" type="float" middle />{' '}
						{this.current_currency.sign}
					</Field>
				</FieldGroup>
			</div>
		);
	}

	get current_currency(): ICurrency {
		return this.params.currencies.find(currency => currency.current);
	}
}
