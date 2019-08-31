import React, { ReactNode } from 'react';
import ContextComponent from 'settings/context/ContextComponent';
import Field from 'lib/waui/Field/Field';
import StorefrontCheckbox from 'lib/control/domain/StorefrontCheckbox/StorefrontCheckbox';
import StorefrontInputText from 'lib/control/domain/StorefrontInputText/StorefrontInputText';
import StorefrontSelect from 'lib/control/domain/StorefrontSelect/StorefrontSelect';
import { observer } from 'mobx-react';
import Select, { ISelectOption } from 'lib/waui/Select/Select';
import SubHeader from 'lib/waui/SubHeader/SubHeader';
import SettingsModelIdSelect from 'settings/components/SettingsModelIdSelect/SettingsModelIdSelect';

@observer
export default class DiscountSettings extends ContextComponent {
	render(): ReactNode {
		return (
			<div>
				<SettingsModelIdSelect model={this.storefront_settings} />

				<Field label="Скидки включены">
					<StorefrontCheckbox name="discount.status" />
				</Field>

				<SubHeader>Купоны</SubHeader>

				{this.coupon_type_options.length > 1 && (
					<Field label="Тип купонов">
						<StorefrontSelect
							options={this.coupon_type_options}
							name="discount.coupon_type"
							short
						/>
					</Field>
				)}

				<Field label="Количество символов в купоне">
					<StorefrontInputText name="discount.coupon_length" type="int" short />
				</Field>

				<Field label="Префикс купона">
					<StorefrontInputText
						name="discount.coupon_prefix"
						allowedSymbols="a-z0-9_\-"
						allowEmpty
					/>
				</Field>

				<SubHeader>Параметры скидки</SubHeader>

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

				<SubHeader>Бонусы за фотографии к отзывам</SubHeader>

				{this.params.is_review_images_allowed && (
					<>
						<Field
							label="Бонус за фотографии в отзыве"
							hint="Выдается при наличии хотя бы 1 фотографии в отзыве"
						>
							<StorefrontInputText name="discount.image_bonus_value" type="float" short />{' '}
							<StorefrontSelect
								options={this.discount_unit_options}
								name="discount.image_bonus_unit"
								short
							/>
						</Field>

						<Field label="Бонус за каждую фотографию в отзыве">
							<StorefrontInputText name="discount.image_bonus_per_1_value" type="float" short />{' '}
							<StorefrontSelect
								options={this.discount_unit_options}
								name="discount.image_bonus_per_1_unit"
								short
							/>
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

	get coupon_type_options(): ISelectOption[] {
		const coupon_type_options = [
			{
				value: 'default',
				label: 'Купоны магазина'
			}
		];

		if (this.params.integration_availability.flexdiscount) {
			coupon_type_options.push({
				value: 'flexdiscount',
				label: 'Купоны плагина "Гибкие скидки"'
			});
		}

		return coupon_type_options;
	}
}
