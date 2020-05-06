import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class Category extends Component {
    data(){
        return {
            myStatus:'Inactive',
            myStyleClass:'text-danger'
        }
    }
    statusPrint(status){
        if(status==true){
            this.data.myStatus = 'Active';
            this.data.myStyleClass = 'text-success';
        }else{
            this.data.myStatus = 'Inactive';
            this.data.myStyleClass = 'text-danger';
        }
    }
    render() {
        return (
            <div className="col-md-12 p0">
                <div className="panel panel-default">
                    <div className="panel-heading">
                        <div className="col-md-6 p5">
                            <h4 className="m0">{this.props.category_name}</h4>
                            {this.statusPrint(this.props.status)}
                            <small className={this.data.myStyleClass}>{this.data.myStatus}</small>
                        </div>
                        <div className="col-md-6 p5 text-right">
                            <input type="number" onChange={this.props.changeOrder.bind(this)} value={this.props.order} min="1" />
                        </div>
                        <div className="clearfix"></div>
                    </div>
                    <div className="panel-body">
                        <button type="button" onClick={() => this.props.alerter(this.props.number)}>++++</button>
                    </div>
                </div>
            </div>
        );
    }
}