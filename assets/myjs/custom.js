var billtype = $('#billtype').val();
var d_csrf = crsf_token + '=' + crsf_hash;
$('#addproduct').on('click', function () {
    // alert("ok");
    var cvalue = parseInt($('#ganak').val()) + 1;
    var nxt = parseInt(cvalue);
    $('#ganak').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row div').length;
//product row
    var data = '<tr><td id="rownumber-' + cvalue + '"></td><td class="hidden"><input type="text" class="form-control text-center" name="purchase_id[]"  value="0" id="purchaseid-' + cvalue + '"></td><td><input type="text" class="form-control text-center" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '"></td><td><input type="text" class="form-control text-center" name="body_number[]" placeholder="Enter Body number" id="bodynumber-' + cvalue + '"></td><td><input type="text" class="form-control text-center" name="engine_number[]" placeholder="Enter Engine number" id="enginenumber-' + cvalue + '"></td><td><input type="text" class="form-control text-center" name="plate_number[]" placeholder="Enter Plate Number" id="platenumber-' + cvalue + '"></td><td><input type="text" class="form-control text-center" name="other_expense[]" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" placeholder="Enter Expense" id="otherexpense-' + cvalue + '"></td><td class="hidden"><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1" ><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td><td> <input type="text" class="form-control vat" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td> <td><input type="text" class="form-control discount" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td><td class="hidden"><input type="text" class="form-control discount" name="purchase_paid_amount[]" onkeypress="return isNumber(event)" id="purchasepaidamount-0" autocomplete="off"></td><td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> </tr><tr><td></td><td colspan="12"><textarea class="form-control"  id="dpid-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea><br></td></tr>';
    //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);

    row = cvalue;

    $('#productname-' + cvalue).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseurl + 'search_products/' + billtype,
                dataType: "json",
                method: 'post',
                data: 'name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
                success: function (data) {
                    response($.map(data, function (item) {
                        var product_d = item[0];
                        return {
                            label: product_d,
                            value: product_d,
                            data: item
                        };
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {
            id_arr = $(this).attr('id');
            id = id_arr.split("-");
            var t_r = ui.item.data[3];
            if ($("#taxformat option:selected").attr('data-trate')) {

                t_r = $("#taxformat option:selected").attr('data-trate');
            }
            var discount = ui.item.data[4];
            var custom_discount = $('#custom_discount').val();
            if (custom_discount > 0) discount = deciFormat(custom_discount);

            $('#amount-' + id[1]).val(1);
            $('#price-' + id[1]).val(ui.item.data[1]);
            $('#pid-' + id[1]).val(ui.item.data[2]);
            $('#vat-' + id[1]).val(t_r);
            $('#discount-' + id[1]).val(discount);
            $('#dpid-' + id[1]).val(ui.item.data[5]);
            $('#unit-' + id[1]).val(ui.item.data[6]);
            $('#hsn-' + id[1]).val(ui.item.data[7]);
            $('#alert-' + id[1]).val(ui.item.data[8]);
            rowTotal(cvalue);
            billUpyog();


        },
        create: function (e) {
            $(this).prev('.ui-helper-hidden-accessible').remove();
        }
    });
    rownumber();
});
$('#addproductsale').on('click', function () {
    var cvalue = parseInt($('#ganak').val()) + 1;
    var nxt = parseInt(cvalue);
    $('#ganak').val(nxt);
    var functionNum = "'" + cvalue + "'";
    var invoice = $(this).attr("invoice");
    count = $('#saman-row div').length;
//product row
    var data = '<tr><td id="rownumber-' + cvalue + '"></td><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '"><input type="text" class="form-control req amnt hidden" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1" ><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"></td>'
            +'<td><input type="text" class="form-control" name="product_body_num[]" data-text="detail-item" placeholder="" id="productbodynumber-' + cvalue + '" ></td>'
            +'<td><input type="text" class="form-control" name="product_machine_num[]" data-text="detail-item" placeholder="" id="productmachinenumber-' + cvalue + '" ></td>'
            +'<td><input type="text" class="form-control" name="product_plate_num[]" data-text="detail-item" placeholder="" id="productplatenumber-' + cvalue + '" ></td>'
            +'<td><i id="product_check-' + cvalue + '" class="icon-close text-danger"></i></td>'
            +'<td><input type="text" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td><td> <input type="text" class="form-control vat" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td> <td><input type="text" class="form-control discount" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"><input type="hidden" class="psIn" name="psid[]" id="psid-' + cvalue + '" value="0"><input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> </tr><tr><td></td><td colspan="11"><textarea class="form-control"  id="dpid-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea><br></td></tr>';
    //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);

    row = cvalue;

    $('#productname-' + cvalue).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseurl + 'search_products/' + billtype,
                dataType: "json",
                method: 'post',
                data: 'name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
                success: function (data) {
                    response($.map(data, function (item) {
                        var product_d = item[0];
                        return {
                            label: product_d,
                            value: product_d,
                            data: item
                        };
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {
            id_arr = $(this).attr('id');
            id = id_arr.split("-");
            var t_r = ui.item.data[3];
            if ($("#taxformat option:selected").attr('data-trate')) {

                t_r = $("#taxformat option:selected").attr('data-trate');
            }
            var discount = ui.item.data[4];
            var custom_discount = $('#custom_discount').val();
            if (custom_discount > 0) discount = deciFormat(custom_discount);

            $('#amount-' + id[1]).val(1);
            $('#price-' + id[1]).val(ui.item.data[1]);
            $('#pid-' + id[1]).val(ui.item.data[2]);
            $('#vat-' + id[1]).val(t_r);
            $('#discount-' + id[1]).val(discount);
            $('#dpid-' + id[1]).val(ui.item.data[5]);
            $('#unit-' + id[1]).val(ui.item.data[6]);
            $('#hsn-' + id[1]).val(ui.item.data[7]);
            $('#alert-' + id[1]).val(ui.item.data[8]);
            rowTotal(cvalue);
            billUpyog();


        },
        create: function (e) {
            $(this).prev('.ui-helper-hidden-accessible').remove();
        }
    });
    $('#productbodynumber-'+cvalue+',#productmachinenumber-'+cvalue+',#productplatenumber-'+cvalue+'').autocomplete({
        source: function (request, response) {
            var id = this.element[0].id;
            var tname = id.split('-')[0];
            var tid = id.split('-')[1];
            var col1,col2,col3,val1,val2,val3;
            if(tname==='productbodynumber'){
                col1='body_number';
                col2='engine_number';
                col3='plate_number';
                val1=$("#productbodynumber-"+tid).val();
                val2=$("#productmachinenumber-"+tid).val();
                val3=$("#productplatenumber-"+tid).val();
            }
            else if(tname==='productmachinenumber'){
                col1='engine_number';
                col2='body_number';
                col3='plate_number';
                val1=$("#productmachinenumber-"+tid).val();
                val2=$("#productbodynumber-"+tid).val();
                val3=$("#productplatenumber-"+tid).val();
            }
            else if(tname==='productplatenumber'){
                col1='plate_number';
                col2='engine_number';
                col3='body_number';
                val1=$("#productplatenumber-"+tid).val();
                val2=$("#productmachinenumber-"+tid).val();
                val3=$("#productbodynumber-"+tid).val();
            }
            $.ajax({
                url: baseurl + 'search_products/search_body_num',
                dataType: "json",
                method: 'post',
                data: 'name_startsWith=' + request.term + '&type=product_list&row_num=1&wid=' + $("#s_warehouses option:selected").val() + '&pid=' + $("#pid-"+tid).val() + '&col1='+col1+'&col2='+col2+'&col3='+col3+'&val2='+val2+'&val3='+val3+'&invoice='+invoice+'&' + d_csrf,
                success: function (data) {
                    response($.map(data, function (item) {
                        var product_d = item[0];
                        return {
                            label: product_d,
                            value: product_d,
                            data: item
                        };
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        close: function (event, ui) {
            var id = $(this).attr('id');
            if(id.split('-')[0]==='productplatenumber'){
                $("#price-"+id.split('-')[1]).focus();
            }
            selectItem(id.split('-')[1]);
        }
    });
    rownumber();
});

function rownumber(){
    var i = 1;
    $("#saman-row").find("td[id^=rownumber]").each(function(e){
        $(this).html(i);
        i++;
    });
}

$("#saman-row").on('change',"[data-text='detail-item']",function(e){
    var id = $(this)[0].id;
    if(id.split('-')[0]==='productname'){
        if($("#saman-row").find("#"+id).val().trim()===''){
            $("#saman-row").find('#pid-'+id.split('-')[1]).val(0);
        }
    }
    selectItem(id.split('-')[1]);
});
$("#saman-row").on('keyup',"[data-text='detail-item']",function(e){
    var id = $(this)[0].id;
    if(id.split('-')[0]==='productplatenumber'){
        if($("#saman-row").find("#"+id).val().trim()===''){
            selectItem(id.split('-')[1]);
        }
    }
    selectItem(id.split('-')[1]);
});
//caculations
var precentCalc = function (total, percentageVal) {
    var pr = (total / 100) * percentageVal;
    return parseFloat(pr);
};
//format
var deciFormat = function (minput) {
    if (!minput) minput = 0;
    return parseFloat(minput).toFixed(2);
};
var formInputGet = function (iname, inumber) {
    var inputId;
    inputId = iname + '-' + inumber;
    var inputValue = $(inputId).val();

    if (inputValue == '') {

        return 0;
    } else {
        return inputValue;
    }
};

//ship calculation
var coupon = function () {
    var cp = 0;
    if ($('#coupon_amount').val()) {
        cp = accounting.unformat($('#coupon_amount').val(), accounting.settings.number.decimal);
    }
    return cp;
};
var shipTot = function () {
    var ship_val = accounting.unformat($('.shipVal').val(), accounting.settings.number.decimal);
    var ship_p = 0;
    if ($("#taxformat option:selected").attr('data-trate')) {
        var ship_rate = $("#taxformat option:selected").attr('data-trate');
    } else {
        var ship_rate = accounting.unformat($('#ship_rate').val(), accounting.settings.number.decimal);
    }
    var tax_status = $("#ship_taxtype").val();
    if (tax_status == 'excl') {
        ship_p = (ship_val * ship_rate) / 100;
        ship_val = ship_val + ship_p;
    } else if (tax_status == 'incl') {
        ship_p = (ship_val * ship_rate) / (100 + ship_rate);
    }
    $('#ship_tax').val(accounting.formatNumber(ship_p));
    $('#ship_final').html(accounting.formatNumber(ship_p));
    return ship_val;
};

//product total
var samanYog = function () {
    var itempriceList = [];
    var idList = [];
    var r = 0;
    $('.ttInput').each(function () {
        var vv = accounting.unformat($(this).val(), accounting.settings.number.decimal);
        var vid = $(this).attr('id');
        vid = vid.split("-");
        itempriceList.push(vv);
        idList.push(vid[1]);
        r++;
    });
    var sum = 0;
    var taxc = 0;
    var discs = 0;
    for (var z = 0; z < idList.length; z++) {
        var x = idList[z];
        if (itempriceList[z] > 0) {
            sum += itempriceList[z];
        }
        var t1=accounting.unformat($("#taxa-" + x).val(), accounting.settings.number.decimal);
        var d1=accounting.unformat($("#disca-" + x).val(), accounting.settings.number.decimal);
        if (t1 > 0) {
            taxc += t1;
        }
        if (d1 > 0) {
            discs += d1;
        }
    }

    $("#discs").html(accounting.formatNumber(discs));
    $("#taxr").html(accounting.formatNumber(taxc));
    return accounting.unformat(sum, accounting.settings.number.decimal);
};

//actions
var deleteRow = function (num) {
    var totalSelector = $("#subttlform");
    var prodttl = accounting.unformat($("#total-" + num).val(),accounting.settings.number.decimal);
    var subttl =  accounting.unformat(totalSelector.val(),accounting.settings.number.decimal);
    var totalSubVal =subttl - prodttl;
    totalSelector.val(totalSubVal);
    $("#subttlid").html(accounting.formatNumber(totalSubVal));
    var totalBillVal = totalSubVal + shipTot - coupon;
    //final total
    var clean = accounting.formatNumber(totalBillVal);
    $("#mahayog").html(clean);
    $("#invoiceyoghtml").val(clean);
    $("#bigtotal").html(clean);
};


var billUpyog = function () {
    var out = 0;
    var disc_val = accounting.unformat($('.discVal').val(),accounting.settings.number.decimal);
    if (disc_val) {
        $("#subttlform").val( accounting.formatNumber(samanYog()));
        var disc_rate = $('#discountFormat').val();

        switch (disc_rate) {
            case '%':
                out = precentCalc(accounting.unformat($('#subttlform').val(),accounting.settings.number.decimal), disc_val);
                break;
            case 'b_p':
                out = precentCalc(accounting.unformat($('#subttlform').val(),accounting.settings.number.decimal), disc_val);
                break;
            case 'flat':
                out = accounting.unformat(disc_val,accounting.settings.number.decimal);
                break;
            case 'bflat':
                out = accounting.unformat(disc_val,accounting.settings.number.decimal);
                break;
        }
        out = parseFloat(out).toFixed(two_fixed);

        $('#disc_final').html(accounting.formatNumber(out));
        $('#after_disc').val(accounting.formatNumber(out));
    } else {
        $('#disc_final').html(0);
        $('#after_disc').val(0);
    }
    var totalBillVal = accounting.formatNumber(samanYog() + shipTot() - coupon() - out);
    $("#mahayog").html(totalBillVal);
    $("#subttlform").val(accounting.formatNumber(samanYog()));
    $("#invoiceyoghtml").val(totalBillVal);
    $("#bigtotal").html(totalBillVal);
};

var o_rowTotal = function (numb) {
    //most res
    var result;
    var totalValue;
    var amountVal = formInputGet("#amount", numb);
    var priceVal = formInputGet("#price", numb);
    var discountVal = formInputGet("#discount", numb);
    if (discountVal == '') {
        $("#discount-" + numb).val(0);
        discountVal = 0;
    }
    var vatVal = formInputGet("#vat", numb);
    if (vatVal == '') {
        $("#vat-" + numb).val(0);
        vatVal = 0;
    }
    var taxo = 0;
    var disco = 0;
    var totalPrice = (parseFloat(amountVal).toFixed(2)) * priceVal;
    var tax_status = $("#taxformat option:selected").val();
    var disFormat = $("#discount_format").val();

    //tax after bill
    if (tax_status == 'yes') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            var Inpercentage = precentCalc(totalPrice, vatVal);
            totalValue = parseFloat(totalPrice) + parseFloat(Inpercentage);
            taxo = deciFormat(Inpercentage);


            if (disFormat == 'flat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discountVal);
            } else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discount);
                disco = deciFormat(discount);
            }

        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

            //tax
            var Inpercentage = precentCalc(totalValue, vatVal);
            totalValue = parseFloat(totalValue) + parseFloat(Inpercentage);
            taxo = deciFormat(Inpercentage);


        }
    } else if (tax_status == 'inclusive') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            var Inpercentage = (+totalPrice * +vatVal) / (100 + +vatVal);
            totalValue = parseFloat(totalPrice);
            taxo = deciFormat(Inpercentage);


            if (disFormat == 'flat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discountVal);
            } else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discount);
                disco = deciFormat(discount);
            }

        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

            //tax
            var Inpercentage = (+totalPrice * +vatVal) / (100 + +vatVal);
            totalValue = parseFloat(totalValue);
            taxo = deciFormat(Inpercentage);


        }
    } else {
        taxo = 0;
        if (disFormat == '%' || disFormat == 'flat') {
            //tax

            //  totalValue = deciFormat(totalPrice);


            if (disFormat == 'flat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            } else if (disFormat == '%') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }
        }
    }
    $("#result-" + numb).html(deciFormat(totalValue));
    $("#taxa-" + numb).val(taxo);
    $("#texttaxa-" + numb).text(taxo);
    $("#disca-" + numb).val(disco);
    var totalID = "#total-" + numb;
    $(totalID).val(deciFormat(totalValue));
    samanYog();
};
var rowTotal = function (numb) {
    //most res
    var result;
    var page = '';
    var totalValue = 0;
    var amountVal = accounting.unformat($("#amount-" + numb).val(), accounting.settings.number.decimal);
    var priceVal = accounting.unformat($("#price-" + numb).val(), accounting.settings.number.decimal);
    var discountVal = accounting.unformat($("#discount-" + numb).val(), accounting.settings.number.decimal);
    var vatVal = accounting.unformat($("#vat-" + numb).val(), accounting.settings.number.decimal);
    
    // Srieng modified 27-10-2020
    var expense = accounting.unformat($("#otherexpense-" + numb).val(), accounting.settings.number.decimal);
    // priceVal += expense;
    // alert(priceVal);
    // End
    //alert(expense);
    var taxo = 0;
    var disco = 0;
    var totalPrice = amountVal.toFixed(two_fixed) * priceVal;
    var tax_status = $("#taxformat option:selected").val();
    var disFormat = $("#discount_format").val();
   
    //tax after bill
    if (tax_status == 'yes') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            var Inpercentage = precentCalc(totalPrice, vatVal);
            totalValue = (totalPrice+expense) + Inpercentage;
            taxo = accounting.formatNumber(Inpercentage);
            if (disFormat == 'flat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalValue - discountVal;
            } else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = totalValue - discount;
                disco = accounting.formatNumber(discount);
            }
        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }

            //tax
            var Inpercentage = precentCalc(totalValue, vatVal);
            totalValue = (totalValue+expense) + Inpercentage;
            taxo = accounting.formatNumber(Inpercentage);
        }
    } else if (tax_status == 'inclusive') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            var Inpercentage = (totalPrice * vatVal) / (100 + vatVal);
            totalValue = totalPrice + expense;
            taxo = accounting.formatNumber(Inpercentage);
            if (disFormat == 'flat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalValue - discountVal;
            } else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = totalValue - discount;
                disco = accounting.formatNumber(discount);
            }
        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = (totalPrice+expense) - discountVal;
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = (totalPrice+expense) - discount;
                disco = accounting.formatNumber(discount);
            }
            //tax
            var Inpercentage = ((totalPrice) * vatVal) / (100 + vatVal);
            totalValue = totalValue+expense;
            taxo = accounting.formatNumber(Inpercentage);
        }
    } else {
        taxo = 0;
        if (disFormat == '%' || disFormat == 'flat') {
            if (disFormat == 'flat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = (totalPrice+expense) - discountVal;
            } else if (disFormat == '%') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = (totalPrice+expense) - discount;
                disco = accounting.formatNumber(discount);
            }

        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = (totalPrice+expense) - discountVal;
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = (totalPrice+expense) - discount;
                disco = accounting.formatNumber(discount);
            }
        }
    }
    $("#result-" + numb).html(accounting.formatNumber(totalValue));
    $("#taxa-" + numb).val(taxo);
    $("#texttaxa-" + numb).text(taxo);
    $("#disca-" + numb).val(disco);
    $("#total-" + numb).val(accounting.formatNumber(totalValue));
    samanYog();
    rownumber();
};
var changeTaxFormat = function (getSelectv) {

    if (getSelectv == 'yes') {
        var tformat = $('#taxformat option:selected').data('tformat');
        var trate = $('#taxformat option:selected').data('trate');
        $("#tax_status").val(tformat);
        $("#tax_format").val('%');
    } else if (getSelectv == 'inclusive') {
        var tformat = $('#taxformat option:selected').data('tformat');
        var trate = $('#taxformat option:selected').data('trate');
        $("#tax_status").val(tformat);
        $("#tax_format").val('incl');

    } else {
        $("#tax_status").val('no');
        $("#tax_format").val('off');

    }
    var discount_handle = $("#discountFormat").val();
    var tax_handle = $("#tax_format").val();
    formatRest(tax_handle, discount_handle, trate);
}

var changeDiscountFormat = function (getSelectv) {
    if (getSelectv != '0') {
        $(".disCol").show();
        $("#discount_handle").val('yes');
        $("#discount_format").val(getSelectv);
    } else {
        $("#discount_format").val(getSelectv);
        $(".disCol").hide();
        $("#discount_handle").val('no');
    }
    var tax_status = $("#tax_format").val();
    formatRest(tax_status, getSelectv);
}

function formatRest(taxFormat, disFormat, trate = '') {
    var amntArray = [];
    var idArray = [];
    $('.amnt').each(function () {
        var v = accounting.unformat($(this).val(), accounting.settings.number.decimal);
        var id_e = $(this).attr('id');
        id_e = id_e.split("-");
        idArray.push(id_e[1]);
        amntArray.push(v);
    });
    var prcArray = [];
    $('.prc').each(function () {
        var v = accounting.unformat($(this).val(), accounting.settings.number.decimal);
        prcArray.push(v);
    });
    var vatArray = [];
    $('.vat').each(function () {
        if (trate) {
            var v = accounting.unformat(trate, accounting.settings.number.decimal);
            $(this).val(v);
        } else {
            var v = accounting.unformat($(this).val(), accounting.settings.number.decimal);
        }
        vatArray.push(v);
    });

    var discountArray = [];
    $('.discount').each(function () {
        var v = accounting.unformat($(this).val(), accounting.settings.number.decimal);
        discountArray.push(v);
    });

    var taxr = 0;
    var discsr = 0;
    for (var i = 0; i < idArray.length; i++) {
        var x = idArray[i];
        amtVal = amntArray[i];
        prcVal = prcArray[i];
        vatVal = vatArray[i];
        discountVal = discountArray[i];
        var result = amtVal * prcVal;
        if (vatVal == '') {
            vatVal = 0;
        }
        if (discountVal == '') {
            discountVal = 0;
        }
        if (taxFormat == '%') {
            if (disFormat == '%' || disFormat == 'flat') {
                var Inpercentage = precentCalc(result, vatVal);
                var result = result + Inpercentage;
                taxr = taxr + Inpercentage;
                $("#texttaxa-" + x).html(accounting.formatNumber(Inpercentage));
                $("#taxa-" + x).val(accounting.formatNumber(Inpercentage));

                if (disFormat == '%') {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == 'flat') {
                    result = parseFloat(result) - parseFloat(discountVal);
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }
            } else {
                if (disFormat == 'b_p') {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == 'bflat') {
                    result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }

                var Inpercentage = precentCalc(result, vatVal);
                result = result + Inpercentage;
                taxr = taxr + Inpercentage;
                $("#texttaxa-" + x).html(accounting.formatNumber(Inpercentage));
                $("#taxa-" + x).val(accounting.formatNumber(Inpercentage));

            }
        } else if (taxFormat == 'incl') {

            if (disFormat == '%' || disFormat == 'flat') {


                var Inpercentage = (result * vatVal) / (100 + vatVal);

                taxr = taxr + Inpercentage;
                $("#texttaxa-" + x).html(accounting.formatNumber(Inpercentage));
                $("#taxa-" + x).val(accounting.formatNumber(Inpercentage));

                if (disFormat == '%') {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == 'flat') {
                    result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }
            } else {
                if (disFormat == 'b_p') {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == 'bflat') {
                    result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }

                var Inpercentage = (result * vatVal) / (100 + vatVal);
                taxr = taxr + Inpercentage;
                $("#texttaxa-" + x).html(accounting.formatNumber(Inpercentage));
                $("#taxa-" + x).val(accounting.formatNumber(Inpercentage));

            }
        } else {

            if (disFormat == '%' || disFormat == 'flat') {

                var result = accounting.unformat($("#amount-" + x).val(), accounting.settings.number.decimal) * accounting.unformat($("#price-" + x).val(), accounting.settings.number.decimal);
                $("#texttaxa-" + x).html('Off');
                $("#taxa-" + x).val(0);
                taxr += 0;

                if (disFormat == '%') {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == 'flat') {
                    var result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }
            } else {
                if (disFormat == 'b_p') {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == 'bflat') {
                    result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }
                $("#texttaxa-" + x).html('Off');
                $("#taxa-" + x).val(0);
                taxr += 0;
            }
        }

        $("#total-" + x).val(accounting.formatNumber(result));
        $("#result-" + x).html(accounting.formatNumber(result));


    }
    var sum = accounting.formatNumber(samanYog());
    $("#subttlid").html(sum);
    $("#taxr").html(accounting.formatNumber(taxr));
    $("#discs").html(accounting.formatNumber(discsr));
    billUpyog();
}

//remove productrow


$('#saman-row').on('click', '.removeProd', function () {
    
    var rmstock_id = $(this).attr("stock-id");
    var rmpaid = $(this).attr("paid-amount");
    if(rmstock_id!==undefined && rmpaid!==undefined){
        $('<input>').attr({
            type: 'text',
            id: 'rmstock',
            name: 'rmstock[]',
            value: rmstock_id
        }).appendTo('[role="stock-id-remove"]');
        $('<input>').attr({
            type: 'text',
            id: 'rmpaid',
            name: 'rmpaid[]',
            value: rmpaid
        }).appendTo('[role="stock-id-remove"]');
    }
    var pidd = $(this).closest('tr').find('.pdIn').val();
    var pqty = $(this).closest('tr').find('.amnt').val();
    pqty = pidd + '-' + pqty;
    $('<input>').attr({
        type: 'hidden',
        id: 'restock',
        name: 'restock[]',
        value: pqty
    }).appendTo('form');
    $(this).closest('tr').remove();
    $('#d' + $(this).closest('tr').find('.pdIn').attr('id')).closest('tr').remove();
    $('.amnt').each(function (index) {
        rowTotal(index);
        billUpyog();
    });

    return false;
});
$('#productname-0').autocomplete({
    source: function (request, response) {
        $.ajax({
            url: baseurl + 'search_products/' + billtype,
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + request.term + '&type=product_list&row_num=1&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
            success: function (data) {
                response($.map(data, function (item) {
                    var product_d = item[0];
                    return {
                        label: product_d,
                        value: product_d,
                        data: item
                    };
                }));
            }
        });
    },
    autoFocus: true,
    minLength: 0,
    select: function (event, ui) {
        var t_r = ui.item.data[3];
        if ($("#taxformat option:selected").attr('data-trate')) {

            t_r = $("#taxformat option:selected").attr('data-trate');
        }
        var discount = ui.item.data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
        $('#amount-0').val(1);
        $('#price-0').val(ui.item.data[1]);
        $('#pid-0').val(ui.item.data[2]);
        $('#vat-0').val(t_r);
        $('#discount-0').val(discount);
        $('#dpid-0').val(ui.item.data[5]);
        $('#unit-0').val(ui.item.data[6]);
        $('#hsn-0').val(ui.item.data[7]);
        $('#alert-0').val(ui.item.data[8]);
        rowTotal(0);

        billUpyog();


    }
});
$('#productbodynumber-0,#productmachinenumber-0,#productplatenumber-0').autocomplete({
    source: function (request, response) {
        var id = this.element[0].id;
        var tname = id.split('-')[0];
        var tid = id.split('-')[1];
        var col1,col2,col3,val1,val2,val3;
        if(tname==='productbodynumber'){
            col1='body_number';
            col2='engine_number';
            col3='plate_number';
            val1=$("#productbodynumber-"+tid).val();
            val2=$("#productmachinenumber-"+tid).val();
            val3=$("#productplatenumber-"+tid).val();
        }
        else if(tname==='productmachinenumber'){
            col1='engine_number';
            col2='body_number';
            col3='plate_number';
            val1=$("#productmachinenumber-"+tid).val();
            val2=$("#productbodynumber-"+tid).val();
            val3=$("#productplatenumber-"+tid).val();
        }
        else if(tname==='productplatenumber'){
            col1='plate_number';
            col2='engine_number';
            col3='body_number';
            val1=$("#productplatenumber-"+tid).val();
            val2=$("#productmachinenumber-"+tid).val();
            val3=$("#productbodynumber-"+tid).val();
        }
        $.ajax({
            url: baseurl + 'search_products/search_body_num',
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + request.term + '&type=product_list&row_num=1&wid=' + $("#s_warehouses option:selected").val() + '&pid=' + $("#pid-"+tid).val() + '&col1='+col1+'&col2='+col2+'&col3='+col3+'&val2='+val2+'&val3='+val3+'&' + d_csrf,
            success: function (data) {
                response($.map(data, function (item) {
                    var product_d = item[0];
                    return {
                        label: product_d,
                        value: product_d,
                        data: item
                    };
                }));
            }
        });
    },
    autoFocus: true,
    minLength: 0,
    close: function (event, ui) {
        var id = $(this).attr('id');
        if(id.split('-')[0]==='productplatenumber'){
            $("#price-"+id.split('-')[1]).focus();
        }
        selectItem(id.split('-')[1]);
    }
});

function selectItem(tid){
    /////i pause here
    //'wid='+$("#s_warehouses option:selected").val()+'&pid='+$("#pid-"+tid).val()+'&body_number='+$("#productbodynumber-"+tid).val()+'&engine_number='+$("#productmachinenumber-"+tid).val()+'&plate_number='+$("#productplatenumber-"+tid).val(),
    var wid = $("#s_warehouses option:selected").val();
    var pid = $("#saman-row").find("#pid-"+tid).val();
    var body_number = $("#saman-row").find("#productbodynumber-"+tid).val();
    var engine_number = $("#saman-row").find("#productmachinenumber-"+tid).val();
    var plate_number = $("#saman-row").find("#productplatenumber-"+tid).val();
    var invoice = $("#addproductsale").attr("invoice");
    $.ajax({
        url: baseurl + 'search_products/search_item_detail/',
        dataType: 'json',
        data: {
            'wid':wid,
            'pid':pid,
            'body_number':body_number,
            'engine_number':engine_number,
            'plate_number':plate_number,
            'invoice':invoice
        },
        success: function (data) {
            if(data.length===1){
                $("#saman-row").find("#psid-"+tid).val(data[0]);
            }
            else{
                $("#saman-row").find("#psid-"+tid).val(0);
            }
            
            if(parseInt($("#saman-row").find("#psid-"+tid).val())!==0&&parseInt(pid)!==0){
                var row = $("#saman-row").find("input[name^='psid'][value='"+data[0]+"']").length;
                if(row<2){
                    $("#saman-row").find("#product_check-"+tid).removeClass("text-danger").removeClass("icon-close");
                    $("#saman-row").find("#product_check-"+tid).addClass("text-success").addClass("icon-check");
                }
                else{
                    $("#saman-row").find("#product_check-"+tid).removeClass("text-success").removeClass("icon-check");
                    $("#saman-row").find("#product_check-"+tid).addClass("text-danger").addClass("icon-close");
                }
            }
            else{
                $("#saman-row").find("#product_check-"+tid).removeClass("text-success").removeClass("icon-check");
                $("#saman-row").find("#product_check-"+tid).addClass("text-danger").addClass("icon-close");
            }
            
        }
    });
}

$(document).on('click', ".select_pos_item", function (e) {
    var pid = $(this).attr('data-pid');
    var stock = accounting.unformat($(this).attr('data-stock'), accounting.settings.number.decimal);
    var flag = true;
    var discount = $(this).attr('data-discount');
    var custom_discount= accounting.unformat($('#custom_discount').val(), accounting.settings.number.decimal);
     if (custom_discount > 0) discount = accounting.formatNumber(custom_discount);

    $('.pdIn').each(function () {
        if (pid == $(this).val()) {

            var pi = $(this).attr('id');
            var arr = pi.split('-');
            pi = arr[1];
            $('#discount-' + pi).val(discount);
            var stotal = accounting.unformat($('#amount-' + pi).val(), accounting.settings.number.decimal) + 1;

            if (stotal <= stock) {
                $('#amount-' + pi).val(accounting.formatNumber(stotal));
                $('#search_bar').val('').focus();
            } else {
                $('#stock_alert').modal('toggle');
            }
            rowTotal(pi);
            billUpyog();
            $('#amount-' + pi).focus();
            flag = false;
        }
    });
    var t_r = $(this).attr('data-tax');
    if ($("#taxformat option:selected").attr('data-trate')) {

        var t_r = $("#taxformat option:selected").attr('data-trate');
    }
    if (flag) {
        var ganak = $('#ganak').val();
        var cvalue = parseInt(ganak);
        var functionNum = "'" + cvalue + "'";
        count = $('#saman-row div').length;
        var data = '<tr id="ppid-' + cvalue + '" class="mb-1"><td colspan="7" ><input type="text" class="form-control text-center p-mobile" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '" value="' + $(this).attr('data-name') + '-' + $(this).attr('data-pcode') + '"><input type="hidden" id="alert-' + cvalue + '" value="' + $(this).attr('data-stock') + '"  name="alert[]"></td></tr><tr><td><input type="text" class="form-control p-mobile p-width req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1" ></td> <td><input type="text" class="form-control p-width p-mobile req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + $(this).attr('data-price') + '"></td><td> <input type="text" class="form-control p-mobile p-width vat" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + t_r + '"></td>  <td><input type="text" class="form-control p-width p-mobile discount pos_w" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + discount + '"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeItem" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="' + $(this).attr('data-pid') + '"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value="' + $(this).attr('data-unit') + '"> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value="' + $(this).attr('data-pcode') + '"></tr>';

        //ajax request
        // $('#saman-row').append(data);
        $('#pos_items').append(data);
        rowTotal(cvalue);
        billUpyog();
        $('#ganak').val(cvalue + 1);
        $('#amount-' + cvalue).focus();

    }
});

$(document).on('click', ".v2_select_pos_item", function (e) {
    var pid = $(this).attr('data-pid');
    var stock =  accounting.unformat($(this).attr('data-stock'), accounting.settings.number.decimal);

    var discount = $(this).attr('data-discount');
    var custom_discount = accounting.unformat($('#custom_discount').val(), accounting.settings.number.decimal);
    if (custom_discount > 0) discount = accounting.formatNumber(custom_discount);
    var flag = true;
    $('#v2_search_bar').val('');
    $('.pdIn').each(function () {

        if (pid == $(this).val()) {

            var pi = $(this).attr('id');
            var arr = pi.split('-');
            pi = arr[1];
            $('#discount-' + pi).val(discount);
            var stotal = accounting.unformat($('#amount-' + pi).val(), accounting.settings.number.decimal) + 1;

            if (stotal <= stock) {
                $('#amount-' + pi).val(accounting.formatNumber(stotal));
                $('#search_bar').val('').focus();
            } else {
                $('#stock_alert').modal('toggle');
            }
            rowTotal(pi);
            billUpyog();

            flag = false;
        }
    });
    var t_r = $(this).attr('data-tax');
    if ($("#taxformat option:selected").attr('data-trate')) {

        var t_r = $("#taxformat option:selected").attr('data-trate');
    }
    var sound = document.getElementById("beep");
    sound.play();
    if (flag) {
        var ganak = $('#ganak').val();
        var cvalue = parseInt(ganak);
        var functionNum = "'" + cvalue + "'";
        count = $('#saman-row div').length;
        var data = ' <div class="row  m-0 pt-1 pb-1 border-bottom"  id="ppid-' + cvalue + '"> <div class="col-6 "> <span class="quantity"><input type="text" class="form-control req amnt display-inline mousetrap" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1" ><div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div></span>' + $(this).attr('data-name') + '-' + $(this).attr('data-pcode') + '</div> <div class="col-3"> ' + $(this).attr('data-price') + ' </div> <div class="col-3"><strong><span class="ttlText" id="result-' + cvalue + '">0</span></strong><a data-rowid="' + cvalue + '" class="red removeItem" title="Remove"> <i class="fa fa-trash"></i> </a></div><input type="hidden" class="form-control text-center" name="product_name[]" id="productname-' + cvalue + '" value="' + $(this).attr('data-name') + '-' + $(this).attr('data-pcode') + '"><input type="hidden" id="alert-' + cvalue + '" value="' + $(this).attr('data-stock') + '"  name="alert[]"><input type="hidden" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + $(this).attr('data-price') + '"> <input type="hidden" class="form-control vat" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + t_r + '"><input type="hidden" class="form-control discount pos_w" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + discount + '"><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="' + $(this).attr('data-pid') + '"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value="' + $(this).attr('data-unit') + '"><input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value="' + $(this).attr('data-pcode') + '"></div>';
        //ajax request
        // $('#saman-row').append(data);
        $('#pos_items').append(data);
        rowTotal(cvalue);
        billUpyog();
        $('#ganak').val(cvalue + 1);
        $('#amount-' + cvalue).focus();
    }
});

$('#saman-pos2').on('click', '.removeItem', function () {
    var pidd = $(this).attr('data-rowid');
    var pqty = accounting.unformat($('#amount-' + pidd).val(), accounting.settings.number.decimal);
    var old_amnt = $('#amount_old-' + pidd).val();
    if (old_amnt) {
        pqty = pidd + '-' + pqty;
        $('<input>').attr({
            type: 'hidden',
            name: 'restock[]',
            value: pqty
        }).appendTo('form');
    }
    $('#ppid-' + pidd).remove();
    $('.amnt').each(function (index) {
        rowTotal(index);
    });
    billUpyog();
    return false;
});


$('#saman-row-pos').on('click', '.removeItem', function () {

    var pidd = $(this).closest('tr').find('.pdIn').val();
    var pqty = accounting.unformat($(this).closest('tr').find('.amnt').val(), accounting.settings.number.decimal);
    var old_amnt = accounting.unformat($(this).closest('tr').find('.old_amnt').val(), accounting.settings.number.decimal);
    if (old_amnt) {
        pqty = pidd + '-' + pqty;
        $('<input>').attr({
            type: 'hidden',
            name: 'restock[]',
            value: pqty
        }).appendTo('form');
    }
    $(this).closest('tr').remove();
    $('#d' + $(this).closest('tr').find('.pdIn').attr('id')).closest('tr').remove();
    $('#p' + $(this).closest('tr').find('.pdIn').attr('id')).remove();
    $('.amnt').each(function (index) {
        rowTotal(index);

    });
    billUpyog();

    return false;

});


$(document).on('click', ".quantity-up", function (e) {
    var spinner = $(this);
    var input = spinner.closest('.quantity').find('input[name="product_qty[]"]');
    var oldValue = accounting.unformat(input.val(), accounting.settings.number.decimal);

    var newVal = oldValue + 1;
    spinner.closest('.quantity').find('input[name="product_qty[]"]').val(accounting.formatNumber(newVal));
    spinner.closest('.quantity').find('input[name="product_qty[]"]').trigger("change");
    var id_arr = $(input).attr('id');
    id = id_arr.split("-");
    rowTotal(id[1]);
    billUpyog();
    return false;
});

$(document).on('click', ".quantity-down", function (e) {
    var spinner = $(this);
    var input = spinner.closest('.quantity').find('input[name="product_qty[]"]');
    var oldValue = accounting.unformat(input.val(), accounting.settings.number.decimal);
    var min = 1;
    if (oldValue <= min) {
        var newVal = oldValue;
    } else {
        var newVal = oldValue - 1;
    }
    spinner.closest('.quantity').find('input[name="product_qty[]"]').val(accounting.formatNumber(newVal));
    spinner.closest('.quantity').find('input[name="product_qty[]"]').trigger("change");
    var id_arr = $(input).attr('id');
    id = id_arr.split("-");
    rowTotal(id[1]);
    billUpyog();
    return false;
});



