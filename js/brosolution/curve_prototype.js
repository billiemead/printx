curvePrototype = {
    getCurveString: function(data){
            if(globalProductOptions[data.option_id]['curve_type'] == 1){
                return '';
            }
            if(globalProductOptions[data.option_id]['curve_type'] == 2){
                var prices = this.getPriceFromQtyBreaks(data.option_id, data.select_id);
            }
            if(globalProductOptions[data.option_id]['curve_type'] == 3){
                var prices = this.getPriceFromQtyRanges(data.option_id, data.select_id);
            }
            
            var price_additional_string = '<td colspan="100"><div style="width: '+this.tableWidth+'px; overflow: auto;"><table class="curve-price-table"><tr><td>Price'+
                    ((globalProductOptions[data.option_id]['option_type'] == 'ink_color')?'</td>':'<br/>Weight</td>');
            $H(prices).each(function(pair){
                price_additional_string += 
                        '<td class="price-curve-item">'+pair.key+((globalProductOptions[data.option_id]['option_type'] == 'ink_color')?'':'<br/>(+/-)')+'</td>'+
                        '<td class="price-curve-values-'+pair.key+'">'+
                            '<input name="product[options]['+data.option_id+'][values]['+data.select_id+'][price_curve]['+pair.key+']" value="'+pair.value.price+'" type="text" size="6" /><br/>'+
                            ((globalProductOptions[data.option_id]['option_type'] == 'ink_color')?'':'<input name="product[options]['+data.option_id+'][values]['+data.select_id+'][weight_curve]['+pair.key+']" value="'+pair.value.weight+'" type="text" size="6" />')+                            
                        '</td>'
                        });
            price_additional_string += '</tr></table></div></td>'
            
            return price_additional_string;
        },
        
    changeCurveString: function(optionId){
            var el = this;
            $H(globalProductOptions[optionId]['values']).each(function(pair){
                data = {'option_id': optionId, 'select_id': pair.key};
                $('price_additional_string_'+optionId+'_'+pair.key).innerHTML = el.getCurveString(data);
            });
            
        },
    addCurveString: function(optionId, selectId){
        var el = this;
            data = {'option_id': optionId, 'select_id': selectId};
            $('price_additional_string_'+optionId+'_'+selectId).innerHTML = el.getCurveString(data);
    },    
    
    getPriceFromQtyBreaks: function(option_id,select_id){
            var option;
            $H(globalProductOptions).each(function(pair){
                if(pair.value.option_type == 'quantity_breaks'){
                    option = pair.value;
                }
            });
            var result = {};
            if(typeof option == 'undefined'){
                return result;
            }
            $H(option.qty).each(function(pair){
                var qty = pair.value;
                if(typeof globalProductOptions[option_id]['curve'] != 'undefined' && typeof globalProductOptions[option_id]['curve'][select_id][qty] != 'undefined' && typeof globalProductOptions[option_id]['curve'][select_id][qty]['weight'] != 'undefined'){
                    var weight = globalProductOptions[option_id]['curve'][select_id][qty]['weight'];
                }else{
                    var weight = '';
                }
                if(typeof globalProductOptions[option_id]['curve'] != 'undefined' && typeof globalProductOptions[option_id]['curve'][select_id][qty] != 'undefined' && typeof globalProductOptions[option_id]['curve'][select_id][qty]['price'] != 'undefined'){
                    var price = globalProductOptions[option_id]['curve'][select_id][qty]['price'];
                } else {
                    var price = '';
                }
                result[qty] = {'price':price,'weight':weight};
            })
            return result;
        },
    getPriceFromQtyRanges: function(option_id,select_id){
        var option;
        $H(globalProductOptions).each(function(pair){
            if(pair.value.option_type == 'quantity_ranges'){
                option = pair.value;
            }
        });
        var result = {};
        if(typeof option == 'undefined'){
            return result;
        }
        $H(option.qty).each(function(pair){
            var qty = pair.value.low+'-'+pair.value.high;
            if(typeof globalProductOptions[option_id]['curve'] != 'undefined' && typeof globalProductOptions[option_id]['curve'][select_id][qty] != 'undefined' && typeof globalProductOptions[option_id]['curve'][select_id][qty]['weight'] != 'undefined'){
                var weight = globalProductOptions[option_id]['curve'][select_id][qty]['weight'];
            }else{
                var weight = '';
            }
            if(typeof globalProductOptions[option_id]['curve'] != 'undefined' && typeof globalProductOptions[option_id]['curve'][select_id][qty] != 'undefined' && typeof globalProductOptions[option_id]['curve'][select_id][qty]['price'] != 'undefined'){
                var price = globalProductOptions[option_id]['curve'][select_id][qty]['price'];
            } else {
                var price = '';
            }
            result[qty] = {'price':price,'weight':weight};
        })

        return result;

    },
    addOwnCurveValues: function(data){
        if(typeof globalProductOptions[data.option_id]['curve'] == 'undefined'){
            globalProductOptions[data.option_id]['curve'] = {};
        }
        globalProductOptions[data.option_id]['curve'][data.select_id] = {};
        if(typeof data.price_curve != 'undefined'){
            $H(data.price_curve).each(function(pair){
                globalProductOptions[data.option_id]['curve'][data.select_id][pair.key] = {'price':pair.value};
            });

            $H(data.weight_curve).each(function(pair){
                globalProductOptions[data.option_id]['curve'][data.select_id][pair.key]['weight'] = pair.value;
            });
        } 
    },
    
    bindCurveSelector: function(optionId) {
            var selectors = $$('#curve_selector_'+optionId+' .curve-selector');
            for(var i=0;i<selectors.length;i++){
                if(!$(selectors[i]).binded){
                    $(selectors[i]).binded = true;
                    Event.observe(selectors[i], 'click', function(){
                        globalProductOptions[optionId]['curve_type'] = this.value;
                        if(this.value == 1){
                            $$('.price_additional_string_'+optionId).each(function(el){el.hide()});
                            $$('#product_option_'+optionId+'_type_printing .product-option-price,#product_option_'+optionId+'_type_printing .product-option-weight-diff').each(function(el){el.disabled=false; el.style.backgroundColor = "#fff";});
                        } else if(this.value == 2) {
                            var exist = false;
                            $$('select').each(function(el){
                                if(el.value == 'quantity_breaks'){
                                    var totalSize = el.offsetWidth + el.offsetHeight;
                                    if(totalSize > 0){
                                       exist = true;
                                    }
                                }
                            });
                            if(!exist && window['paperstock_initial_click'] !== true){
                                alert('You need to add at least one Quantity Breaks option first');
                                this.up().select('.curve-selector[value="1"]')[0].click();
                                return false;
                            }
                            $$('.price_additional_string_'+optionId).each(function(el){el.show()});
                            $$('#product_option_'+optionId+'_type_printing .product-option-price,#product_option_'+optionId+'_type_printing .product-option-weight-diff').each(function(el){el.disabled=true; el.style.backgroundColor = "#e6e6e6"});
                            selectOptionPaperstockType.changeCurveString(optionId);
                        } else if(this.value == 3 ) {
                            var exist = false;
                            $$('select').each(function(el){
                                if(el.value == 'quantity_ranges'){
                                    var totalSize = el.offsetWidth + el.offsetHeight;
                                    if(totalSize > 0){
                                       exist = true;
                                    }
                                }
                            });
                            if(!exist  && window['paperstock_initial_click'] !== true){
                                alert('You need to add at least one Quantity Ranges option first');
                                this.up().select('.curve-selector[value="1"]')[0].click();
                                return false;
                            }
                            $$('.price_additional_string_'+optionId).each(function(el){el.show()});
                            $$('#product_option_'+optionId+'_type_printing .product-option-price,#product_option_'+optionId+'_type_printing .product-option-weight-diff').each(function(el){el.disabled=true; el.style.backgroundColor = "#e6e6e6"});
                            selectOptionPaperstockType.changeCurveString(optionId);
                        }
                    });
                }
            }
    },
    decorateTable: function(optionId){
        var i = 1;
        $$('#select_option_type_row_'+optionId+' > tr').each(function(el){
          if(i<=3){
            el.addClassName('odd');
          }
          if(i>3 && i<=6){
            el.addClassName('even');
          }
          if(i == 6)
            i=1;
          else
            i++;
        })
    }
}

