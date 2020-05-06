import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Category from './category.js';



export class Menu extends Component {
    constructor(props) {
        super(props);

        this.state = {
            rank:1,
            order:[],
            shop_id: $('#shop_id').val(),
            category_name:'',
            status_active:false,
            order_nr:0,
            menuJson: {
                'client_id':$('#shop_id').val(),
                'categories':[],
                'status':true
            }
        }
    }
    alerter(i){
        alert(i);
    }
    renderCategory(){
        $('#menuItems').append('<div class="col-md-12 p0" id="'+this.state.rank+'"></div>');
        ReactDOM.render(<Category
                            category_name={this.state.category_name}
                            status={this.state.status_active}
                            order={this.state.order_nr}
                            number={this.state.rank}
                            alerter={this.alerter}
                            changeOrder={this.changeOrder}
                        />,
            document.getElementById(this.state.rank));
        this.setState(
            {
                rank:this.state.rank+1,
                menuJson:{
                    'client_id':this.state.menuJson.client_id,
                    'categories':this.state.menuJson.categories.concat([
                        {
                            'category_name':this.state.category_name,
                            'status':this.state.status_active,
                            'order':this.state.order_nr
                        }
                    ]),
                    'status':this.state.menuJson.status
                }
            }
        );

    }
    changeOrder(){
        alert('ordering');
    }
    changeStatus(e){
        this.setState({status_active:e.target.checked});
    }
    onChange(e) {
        this.setState({category_name:e.target.value});
    }
    changeOrderNr(e) {
        this.setState({order_nr:e.target.value});
    }
    render() {
        return (
        <div className="col-md-12 p10">
            <div className="col-md-4 p10">
                <label>Category Name : </label>
                <input type="text" id="category_name" value={this.state.category_name} onChange={this.onChange.bind(this)} className="form-control" placeholder="Category name" />
            </div>
            <div className="col-md-1 p10">
                <label>Active : </label>
                <input type="checkbox" id="status_active" value="1" onChange={this.changeStatus.bind(this)}/>
            </div>
            <div className="col-md-2 p10">
                <label>Order Nr. : </label>
                <input type="number" id="order_nr" min="1" value={this.state.order_nr} onChange={this.changeOrderNr.bind(this)} className="form-control" />
            </div>
            <div className="col-md-2 p10">
                <label>&nbsp;</label>
                <button type="button" onClick={() => this.renderCategory()} className="btn btn-primary"><i className="fa fa-plus"></i></button>
            </div>
        </div>
        );
    }
}

    if($('#menuDesign').html()!=undefined){
        ReactDOM.render(<Menu />, document.getElementById('menuDesign'));
    }

