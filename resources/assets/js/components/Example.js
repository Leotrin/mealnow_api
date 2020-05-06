import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class Welcome extends Component {
    render() {
        return (
            <div className="container">
                <div className="row">
                    <div className="col-md-8 col-md-offset-2">
                        <div className="panel panel-default">
                            <div className="panel-heading">Bite ME</div>
                            <div className="panel-body">
                                Something big si comming !
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

if (document.getElementById('app')) {
    ReactDOM.render(<Welcome />, document.getElementById('app'));
}
