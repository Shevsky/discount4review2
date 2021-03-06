import React, { ReactNode } from 'react';
import ContextComponent from 'settings/context/ContextComponent';
import Field from 'lib/waui/Field/Field';
import StorefrontCheckbox from 'lib/control/domain/StorefrontCheckbox/StorefrontCheckbox';
import StorefrontInputText from 'lib/control/domain/StorefrontInputText/StorefrontInputText';
import StorefrontSelect from 'lib/control/domain/StorefrontSelect/StorefrontSelect';
import { observer } from 'mobx-react';
import { ISelectOption } from 'lib/waui/Select/Select';
import SettingsModelIdSelect from 'settings/components/SettingsModelIdSelect/SettingsModelIdSelect';
import FieldGroup from 'lib/waui/FieldGroup/FieldGroup';
import Hint from 'lib/waui/Hint/Hint';
import InlineLink from 'lib/waui/InlineLink/InlineLink';

@observer
export default class DiscountSettings extends ContextComponent {
	render(): ReactNode {
		return (
			<div>
				<SettingsModelIdSelect model={this.storefront_settings} />

				<Field label="Скидки включены">
					<StorefrontCheckbox name="discount.status" />
				</Field>

				<Field
					label="Тип купонов"
					hint={
						this.is_coupons_unavailable && (
							<Hint paddedBottom error>
								Скидки по купонам отключены.{' '}
								<InlineLink href="?action=settings#/discounts/coupons/">
									Включите их в настройках магазина
								</InlineLink>
								, чтобы использовать функционал плагина по выдаче купонов на скидку за отзывы.
							</Hint>
						)
					}
				>
					<StorefrontSelect
						options={this.coupon_type_options}
						name="discount.coupon_type"
						disabled={this.is_coupons_unavailable}
					/>
				</Field>

				<FieldGroup title="Купоны">
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
				</FieldGroup>

				<FieldGroup title="Параметры скидок">
					<Field label="Фиксированный размер скидки">
						<StorefrontInputText name="discount.value" type="float" short />{' '}
						<StorefrontSelect options={this.discount_unit_options} name="discount.unit" short />
					</Field>

					<Field label="Бонус за каждый отзыв">
						<StorefrontInputText name="discount.per_1_value" type="int" short />{' '}
						<StorefrontSelect
							options={this.discount_unit_options}
							name="discount.per_1_unit"
							short
						/>{' '}
						за каждый 1 отзыв
					</Field>

					<Field
						label="Индивидуальные значения скидки"
						hint="Включает индивидуальные значения размера скидки, зависящие от группы пользователя"
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
										/>{' '}
										+{' '}
										<StorefrontInputText
											name="discount.individual_per_1_value"
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
											name="discount.individual_per_1_unit"
											arrayAccess={{
												index: user_group.id,
												defaultValue: this.default_discount_per_1_unit
											}}
											short
										/>{' '}
										за каждый 1 отзыв
									</Field>
								))}
							</Field>
						</>
					)}
				</FieldGroup>

				{this.params.is_review_images_allowed && (
					<FieldGroup title="Бонусы за фотографии к отзывам">
						<Field
							label="Бонус за фотографии в отзывах"
							hint="Выдается при наличии хотя бы 1 фотографии в отзывах"
						>
							<StorefrontInputText name="discount.image_bonus_value" type="float" short />{' '}
							<StorefrontSelect
								options={this.discount_unit_options}
								name="discount.image_bonus_unit"
								short
							/>
						</Field>

						<Field label="Бонус за каждую фотографию в отзывах">
							<StorefrontInputText name="discount.image_bonus_per_1_value" type="float" short />{' '}
							<StorefrontSelect
								options={this.discount_unit_options}
								name="discount.image_bonus_per_1_unit"
								short
							/>
						</Field>
					</FieldGroup>
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

	get default_discount_per_1_unit(): string {
		return this.storefront_settings['discount.per_1_unit'];
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
				value: 'shop_coupons',
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

	get coupon_integration_ids(): string[] {
		return ['shop_coupons', 'flexdiscount'];
	}

	get is_coupons_unavailable(): boolean {
		return Object.entries(this.params.integration_availability)
			.filter(([id]) => this.coupon_integration_ids.includes(id))
			.every(([id, availability]) => !availability);
	}
}
