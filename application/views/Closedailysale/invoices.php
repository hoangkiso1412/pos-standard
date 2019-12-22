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
                        <th>ប្រភេទម៉ូតូ</th>
                       
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                   
                </table>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            draw_data();

            function draw_data(start_date = '', end_date = '') {
                $('#po').DataTable({
                    'processing': true,
                    'serverSide': true,
                    'stateSave': true,
                    responsive: true,
                    <?php datatable_lang();?>
                    'order': [],
                    'ajax': {
                        'url': "<?php echo site_url('closedailysale/ajax_list')?>",
                        'type': 'POST',
                        'data': {
                            '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                            start_date: start_date,
                            end_date: end_date,                          
                         
                        }
                    },
                    'columnDefs': [
                        {
                            'targets': [0],
                            'orderable': false,
                        },
                    ],"aLengthMenu": [[10, 25,50, 100, 200, -1], [10, 25,50, 100, 200, "All"]],
                        "iDisplayLength": 100,
                    dom: 'Blfrtip',
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            footer: true,
                            exportOptions: {
                                columns: [0,1, 2,]
                            }
                        }
                    ],
                });
            };

            $('#search').click(function () {
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();             

                if (start_date != '' && end_date != ) {
                    $('#po').DataTable().destroy();
                    draw_data(start_date, end_date);

                }else {
                    alert("Date range is Required");
                }
            });
        });
    </script>