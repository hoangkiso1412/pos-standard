<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo 'របាយការណ៍ស្តុកទាំងអស់' //$this->lang->line('Purchase Detail Listing') ?>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                    
                <div class="message"></div>
            </div>
            <div class="card-body">
                <div class="row">
                    
                    <div class="col-md-1"​><?php echo $this->lang->line('Date') ?></div>
                    <div class="col-md-2">
                        <input type="text" name="start_date" id="start_date"
                               class="date30 form-control form-control-sm" autocomplete="off"/>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="end_date" id="end_date" class="form-control form-control-sm"
                               data-toggle="datepicker" autocomplete="off"/>
                    </div>
                    <div class="col-md-2">
                        <select name="stock" id="stock" class="form-control form-control-sm">
                            <option value="0"><?php echo 'ជ្រើសរើសស្តុក';//$this->lang->line('Select Stock'); ?></option>
                            <?php $loc = warehouse();
                                
                            foreach ($loc as $row) {
                                echo ' <option value="' . $row['id'] . '"> ' . $row['title'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                        
                    <div class="col-md-2">
                        <select name="inout" id="inout" class="form-control form-control-sm">
                            
                            <option value="0"><?php echo 'ស្ថានភាពស្តុក';//$this->lang->line('Select Stock'); ?></option>
                                
                            <option value="in-stock"><?php echo 'ស្តុកជាក់ស្ដែង';//$this->lang->line('Select Stock'); ?></option>
                            <option value="sold-out"><?php echo 'ស្តុកលក់ចេញ';//$this->lang->line('Select Stock'); ?></option>
                                
                        </select>
                    </div>
                        
                    <div class="col-md-1">
                        <input type="button" name="search" id="search" value="Search" class="btn btn-info btn-sm"/>
                    </div>
                </div>
                <hr>
                    
                <table id="po" class="table table-striped table-bordered zero-configuration" style="font-weight:bold;">
                    <thead>
                        <tr style="color:blue;">
                            <th><?php echo 'ល.រ' ?></th>
                            <th>កាលបរិឆ្ឆេត​</th>
                            <th>ស្តុក</th>
                            <th>ម៉ាក</th>
                            <th>ប្រភេទម៉ូតូ</th>
                            <th>ចំនួន</th>
                            <th>ពណ៌</th>
                            <th>ឆ្នាំ</th>
                            <th>ថ្មី&ចាស់</th>
                            <th>លេខតួ</th>
                            <th>លេខម៉ាស៊ីន</th>
                            <th>អ្នកផ្គត់ផ្គង់</th>
                            <th>អ្នកទិញ</th>
                            <th>តម្លៃទិញ</th>
                            <th>តម្លៃលក់</th>
                            <th>ចំណេញ</th>
                            <th>ចំណេញសុទ្ធ</th>
                            <th>ស្តុកចូល</th>
                            <th>ស្តុកចេញ</th>
                            <th>ស្តុកសល់</th>
                            <th>ថ្ងៃលក់</th>
                            <th>ផ្សេងៗ</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
            
            
    </div>
        
    <div id="edit_profit" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">កែប្រែប្រាក់ចំណេញ</h4>
                </div>
                <div class="modal-body">
                    <form id="editprofit">
                        <div class="row">
                            <div class="col">
                            <input type="text" class="form-control" id="profit_amount" name="profit_amount" value="0">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" class="form-control"
                                   name="tid" id="tid" value="0">
                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal"> <?php echo $this->lang->line('Close') ?></button>
                            <button type="button" class="btn btn-primary"
                                    id="send"> <?php echo $this->lang->line('Update') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
        $(document).ready(function () {
            draw_data();
            function draw_data(start_date = '', end_date = '', stock = 0,inout = 0) {
                $('#po').DataTable({
                    'processing': true,
                    'serverSide': true,
                    'stateSave': true,
                    responsive: true,
                    <?php datatable_lang();?>
                    'order': [],
                    'ajax': {
                        'url': "<?php echo site_url('warehouse/ajax_list')?>",
                        'type': 'POST',
                        'data': {
                            '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                            start_date: start_date,
                            end_date: end_date,
                            stock: stock,
                            inout: inout,

                        }
                    },'rowCallback': function(row, data, index){
                        $(row).find('td:eq(8)').css('color', 'red');
                    },
                    'columnDefs': [
                        {
                            'targets': [0],
                            'orderable': false,
                        },
                    ],"aLengthMenu": [[10, 25,50, 100, 200,500], [10, 25,50, 100, 200, 500]],
                    "iDisplayLength": 100,
                    dom: 'Blfrtip',
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            footer: true,
                            exportOptions: {
                                columns: [0,1, 2, 3, 4, 5,6,7,8,9,10,11,12,13,14,15,16,17,18]
                            }
                        }
                    ], "language":{
    "decimal":        "",
    "emptyTable":     "ពុំមានទិន្និន័យនោះទេ",
    "info":           "បង្ហាញចំនួន  _START_​ រហូតដល់​ _END_ នៃចំនួនសរុប _TOTAL_ ",
    "infoEmpty":      "Showing 0 to 0 of 0 entries",
    "infoFiltered":   "",
    "infoPostFix":    "",
    "thousands":      ",",
    "lengthMenu":     "បង្ហាញចំនួន _MENU_ នៅក្នុងទំព័រនេះ",
    "loadingRecords": "Loading...",
    "processing":     "កំពុងដំណើរការ សូមរង់ចាំបន្ដិច...",
    "search":         "ស្វែងរក :",
    "zeroRecords":    "ទិន្និន័យដែលអ្នកស្វែងរក ពុំមាននោះទេ ",
    "paginate": {
        "first":      "ដំបូង",
        "last":       "ចុងក្រោយ",
        "next":       "បន្ទាប់",
        "previous":   "ត្រឡប់ក្រោយ"
    },
    "aria": {
        "sortAscending":  ": activate to sort column ascending",
        "sortDescending": ": activate to sort column descending"
    }
},"footerCallback": function ( row, data, start, end, display ) {
                        var api = this.api(), data;
                        var numFormat = $.fn.dataTable.render.number( '\,', '.', 2,'' ).display;
                        // Remove the formatting to get integer data for summation
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                                    typeof i === 'number' ?
                            i : 0;
                        };

                        // Total over all pages
                        total = api
                                .column( 13 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                        }, 0 );

                        // Total over this page
                        pageTotal = api
                                .column( 13, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                        }, 0 );

                        // Update footer
                        $( api.column( 13 ).footer() ).html(
                            numFormat(pageTotal) 
                                //'$  '+pageTotal +'<br/> សរុប= $  '+ total
                                );

                        // Total over all pages
                        total = api
                                .column( 14 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                        }, 0 );

                        // Total over this page
                        pageTotal = api
                                .column( 14, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                        }, 0 );

                        // Update footer
                        $( api.column( 14 ).footer() ).html(
                            numFormat(pageTotal) 
                                //   '$  '+pageTotal +'<br/> សរុប= $  '+ total
                                );

                        // Total over all pages
                        total = api
                                .column( 15 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                        }, 0 );

                        // Total over this page
                        pageTotal = api
                                .column( 15, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                        }, 0 );

                        // Update footer
                        $( api.column( 15 ).footer() ).html(
                            numFormat(pageTotal)
                                // '$  '+pageTotal +'<br/> សរុប= $  '+ total
                                );


                         // Total over all pages
                         total = api
                                .column( 16 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                        }, 0 );

                        // Total over this page
                        pageTotal = api
                                .column( 16, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                        }, 0 );

                        // Update footer
                        $( api.column( 16 ).footer() ).html(
                            numFormat(pageTotal)
                                // '$  '+pageTotal +'<br/> សរុប= $  '+ total
                                );


                        // Total over all pages
                        total = api
                                .column( 18 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                        }, 0 );

                        // Total over this page
                        pageTotal = api
                                .column( 18, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                        }, 0 );

                        // Update footer
                        $( api.column( 18).footer() ).html(
                            numFormat(pageTotal)
                                // '$  '+pageTotal +'<br/> សរុប= $  '+ total
                                );

                       
                       

                        // Total over all pages
                        total = api
                                .column( 17 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                        }, 0 );

                        // Total over this page
                        pageTotal = api
                                .column( 17, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                        }, 0 );

                        // Update footer
                        $( api.column( 17 ).footer() ).html(
                                pageTotal
                                // '$  '+pageTotal +'<br/> សរុប= $  '+ total 
                                );

                        // Total over all pages
                        total = api
                                .column( 5 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                        }, 0 );

                        // Total over this page
                        pageTotal = api
                                .column( 5, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                        }, 0 );

                        // Update footer
                        $( api.column( 5 ).footer() ).html(
                            pageTotal
                                );
                   
                        // Total over all pages
                        total = api
                                .column( 19 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                        }, 0 );

                        // Total over this page
                        pageTotal = api
                                .column( 19, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                        }, 0 );

                        // Update footer
                        $( api.column( 19 ).footer() ).html(
                            numFormat(pageTotal)
                                );
                    },
                });
            };

            $('#search').click(function () {

                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();
                var stock = $('#stock').val();
                var inout = $('#inout').val();

                if (start_date != '' && end_date != '' && stock !=0 && inout != 0) {               

                    $('#po').DataTable().destroy();
                    draw_data(start_date, end_date,stock,inout);

                }else if (start_date != '' && end_date != '' && stock !=0) {
                   // alert(stock);
                    $('#po').DataTable().destroy();
                    draw_data(start_date, end_date,stock);

                } else if (start_date != '' && end_date != '' && inout != 0){
                   // alert(inout);
                    $('#po').DataTable().destroy();
                    draw_data(start_date, end_date,inout);

                }else if (start_date != '' && end_date != ''){

                    $('#po').DataTable().destroy();
                    draw_data(start_date, end_date);

                }else {
                    alert("Date range is Required");
                }
            });
            $(document).on('click', "[name='edit-profit']", function (e) {
                e.preventDefault();
                var tid = $(this).attr('data_id');
                $("#profit_amount").val($("#po").find("[edit_id='"+tid+"']").html());
                $("#tid").val(tid);
                $('#edit_profit').modal({backdrop: 'static', keyboard: false}).one('click', '#send', function () {
                    var acturl = 'warehouse/update_profit';
                    updateprofit(acturl,tid);
                });
            });
            function updateprofit(url,id){
                var data_form = $('#editprofit').serialize();
                $.ajax({
                    type: "GET",
                    url: baseurl + url,
                    data: data_form,
                    dataType: 'json',
                    success: function (data){
                        if (data.status === "Success") {
                            $("#po").find("[edit_id='"+id+"']").html(data.amount);
                            $('#edit_profit').modal('hide');
                        }
                        console.log(data);
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }
        });
                        
    </script>
        