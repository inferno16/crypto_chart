import React from 'react';
import ReactDOM from 'react-dom';
import CryptoPriceChart from "./components/CryptoPriceChart";

const ReactApp = () => {
    return (
        <CryptoPriceChart from="BTC" to="USD" />
    );
}

if (document.getElementById('root')) {
    ReactDOM.render(<ReactApp />, document.getElementById('root'));
}
