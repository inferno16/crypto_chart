import React from 'react';
import ReactDOM from 'react-dom';

const ReactApp = () => {
    return (
        <div className="container">
            It's working
        </div>
    );
}

if (document.getElementById('root')) {
    ReactDOM.render(<ReactApp />, document.getElementById('root'));
}
