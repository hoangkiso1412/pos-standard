<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo 'របាយការណ៍លក់សំរាយ';//$this->lang->line('Purchase Detail Listing') ?>
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
                            <option value="0"><?php echo 'ជ្រើសរើសស្ដុក';//$this->lang->line('Select Stock'); ?></option>
                            <?php $loc = warehouse();

                            foreach ($loc as $row) {
                                echo ' <option value="' . $row['id'] . '"> ' . $row['title'] . '</option>';
                            }
                            ?>
                        </select>
                    </div> 
                    <div class="col-md-1">
                        <input type="button" name="search" id="search" value="Search" class="btn btn-info btn-sm"/>
                    </div>

                </div>
                <hr>

                <table id="po" class="table table-striped table-bordered zero-configuration">
                    <thead>
                    <tr>

                        <th><?php echo 'ល.រ'//echo $this->lang->line('No') ?></th>
                        <th>កាលបរិឆ្ឆេត​</th>
                        <th>ស្តុក</th>
                        <th>ប្រភេទ</th>
                        <th>ប្រភេទម៉ូតូ</th>
                        <th>ចំនួន</th>
                        <th>ពណ៌</th>
                        <th>ឆ្នាំ</th>
                        <th>ថ្មី&ចាស់</th>
                        <th>លេខតួ</th>
                        <th>លេខម៉ាស៊ីន</th>
                        <th>អ្នកទិញ</th>
                        <th>តម្លៃ</th>
                        <th>នៅខ្វះ</th>
                        <th>សងប៉ុន្មាន</th>
                        <th>ថ្ងៃសង</th>
                        <th>ផ្សេងៗ</th>
                        <th>បង់លុយ</th>
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
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>


    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            draw_data();

            function draw_data(start_date = '', end_date = '',stock =0) {
                $('#po').DataTable({
                    'processing': true,
                    'serverSide': true,
                    'stateSave': true,
                    responsive: true,
                    <?php datatable_lang();?>
                    'order': [],
                    'ajax': {
                        'url': "<?php echo site_url('sale_detail/ajax_list')?>",
                        'type': 'POST',
                        'data': {
                            '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                            start_date: start_date,
                            end_date: end_date,
                            stock: stock,
                        }
                    },
                    'columnDefs': [
                        {
                            'targets': [0],
                            'orderable': false,
                        },
                    ],'rowCallback': function(row, data, index){
                            if(data[13] !='$ 0.00'){
                                $(row).find('td:eq(13)').css('backgroundColor', 'red');
                                $(row).find('td:eq(13)').css('color', 'white');
                                $(row).find('td:eq(13)').css('font-weight', 'bold');
                            }
                        },
                    dom: 'Blfrtip',
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            footer: true,
                            exportOptions: {
                                columns: [0,1, 2, 3, 4, 5,6,7,8,9,10,11,12,13,14,15,16]
                            }
                        }
                    ],"footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 12 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 12, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 12 ).footer() ).html(
                'សរុប = $  '+ pageTotal
                //'$  '+pageTotal +'<br/> សរុប= $  '+ total 
            );

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
                'សរុប = $  '+ pageTotal
             //   '$  '+pageTotal +'<br/> សរុប= $  '+ total 
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
                'សរុប = $  '+ pageTotal
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
			},
                });
            };

            $('#search').click(function () {
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();
                var stock = $('#stock').val();
                if (start_date != '' && end_date != '' && stock ==0 ) {
                    $('#po').DataTable().destroy();
                    draw_data(start_date, end_date);
                } else if (start_date != '' && end_date != '' && stock !=0 ){
                    $('#po').DataTable().destroy();
                    draw_data(start_date, end_date,stock);
                    
                }
                else {
                    alert("Date range is Required");
                }
            })
        });


      
    </script>