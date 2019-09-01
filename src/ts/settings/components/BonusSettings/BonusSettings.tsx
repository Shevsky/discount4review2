import React, { ReactNode } from 'react';
import ContextComponent from 'settings/context/ContextComponent';
import Field from 'lib/waui/Field/Field';
import StorefrontCheckbox from 'lib/control/domain/StorefrontCheckbox/StorefrontCheckbox';
import { observer } from 'mobx-react';
import SettingsModelIdSelect from 'settings/components/SettingsModelIdSelect/SettingsModelIdSelect';
import Hint from 'lib/waui/Hint/Hint';
import InlineLink from 'lib/waui/InlineLink/InlineLink';
import StorefrontSelect from 'lib/control/domain/StorefrontSelect/StorefrontSelect';
import { ISelectOption } from 'lib/waui/Select/Select';
import FieldGroup from 'lib/waui/FieldGroup/FieldGroup';
import StorefrontInputText from 'lib/control/domain/StorefrontInputText/StorefrontInputText';

@observer
export default class BonusSettings extends ContextComponent {
	render(): ReactNode {
		return (
			<div>
				<SettingsModelIdSelect model={this.storefront_settings} />

				<Field label="Бонусы включены">
					<StorefrontCheckbox name="bonus.status" />
				</Field>

				<Field
					label="Тип бонусов"
					hint={
						this.is_bonuses_unavailable && (
							<Hint paddedBottom error>
								Бонусная программа отключена.{' '}
								<InlineLink href="?action=settings#/affiliate/">
									Включите ее в настройках магазина
								</InlineLink>
								, чтобы использовать функционал плагина по начислению бонусов за отзывы.
							</Hint>
						)
					}
				>
					<StorefrontSelect
						options={this.bonus_type_options}
						name="bonus.type"
						disabled={this.is_bonuses_unavailable}
					/>
				</Field>

				<FieldGroup title="Параметры бонусов">
					<Field label="Фиксированный размер баллов за отзывы">
						<StorefrontInputText name="bonus.value" type="int" short />
					</Field>

					<Field label="Баллов за каждый отзыв">
						<StorefrontInputText name="bonus.per_1_value" type="int" short /> за каждый 1 отзыв
					</Field>

					<Field label="Баллов за процент от суммы заказа">
						<StorefrontInputText name="bonus.order_percent_value" type="int" short /> % от суммы
						заказа
					</Field>

					<Field
						label="Индивидуальные размеры бонусов"
						hint="Включает индивидуальные значения размера бонусов, зависящие от группы пользователя"
					>
						<StorefrontCheckbox name="bonus.individual_status" />
					</Field>

					{this.is_individual_settings && (
						<>
							<Field
								label=""
								hint="Если значение не указано, будет использоваться общее значение размера бонусов"
							>
								{this.params.user_groups.map(user_group => (
									<Field label={user_group.name} vertical key={user_group.id}>
										<StorefrontInputText
											name="bonus.individual_value"
											type="float"
											arrayAccess={{
												index: user_group.id,
												defaultValue: ''
											}}
											allowEmpty
											short
										/>{' '}
										+{' '}
										<StorefrontInputText
											name="bonus.individual_per_1_value"
											type="float"
											arrayAccess={{
												index: user_group.id,
												defaultValue: ''
											}}
											allowEmpty
											short
										/>{' '}
										за каждый 1 отзыв +{' '}
										<StorefrontInputText
											name="bonus.individual_order_percent_value"
											type="float"
											arrayAccess={{
												index: user_group.id,
												defaultValue: ''
											}}
											allowEmpty
											short
										/>{' '}
										% от суммы заказа
									</Field>
								))}
							</Field>
						</>
					)}
				</FieldGroup>

				{this.params.is_review_images_allowed && (
					<FieldGroup title="Бонусы за фотографии к отзывам">
						<Field
							label="Баллов за фотографии в отзывах"
							hint="Выдается при наличии хотя бы 1 фотографии в отзывах"
						>
							<StorefrontInputText name="bonus.image_bonus_value" type="float" short />{' '}
						</Field>

						<Field label="Баллов за каждую фотографию в отзывах">
							<StorefrontInputText name="bonus.image_bonus_per_1_value" type="float" short />{' '}
						</Field>
					</FieldGroup>
				)}
			</div>
		);
	}

	get is_individual_settings(): boolean {
		return this.storefront_settings['bonus.individual_status'];
	}

	get bonus_type_options(): ISelectOption[] {
		const bonus_type_options = [
			{
				value: 'shop_affiliate',
				label: 'Бонусная программа магазина'
			}
		];

		if (this.params.integration_availability.flexdiscount) {
			bonus_type_options.push({
				value: 'flexdiscount',
				label: 'Бонусы плагина "Гибкие скидки"'
			});
		}

		return bonus_type_options;
	}

	get bonus_integration_ids(): string[] {
		return ['shop_affiliate', 'flexdiscount'];
	}

	get is_bonuses_unavailable(): boolean {
		return Object.entries(this.params.integration_availability)
			.filter(([id]) => this.bonus_integration_ids.includes(id))
			.every(([id, availability]) => !availability);
	}
}
