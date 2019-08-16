import React from 'react';
import ContextData from 'settings/context/ContextData';

const Context = React.createContext<ContextData | null>(null);

export default Context;
