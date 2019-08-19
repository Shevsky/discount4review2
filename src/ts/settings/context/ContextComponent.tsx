import React, { Component } from 'react';
import Context from 'settings/context/Context';
import ContextData from 'settings/context/ContextData';
import BasicSettingsModel from 'settings/model/settings/domain/BasicSettingsModel';
import StorefrontSettingsModel from 'settings/model/settings/domain/StorefrontSettingsModel';

interface IContextContext extends React.Context<ContextData> {}

interface IContextComponentProps {
	[key: string]: any;
}

export default class ContextComponent<
	P extends IContextComponentProps = any,
	S = any
> extends Component<P, S> {
	static contextType: IContextContext = Context;

	get params(): IGlobalParams {
		return this.context.params;
	}

	get basic_settings(): BasicSettingsModel {
		return this.context.basic_settings;
	}

	get storefront_settings(): StorefrontSettingsModel {
		return this.context.storefront_settings;
	}
}
