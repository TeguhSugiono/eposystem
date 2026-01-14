
<div class="modal fade" id="modal_formsearch" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" aria-hidden="true" style="margin-top: 1% !important;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title_general" id="basicModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="row gutters">      
                        <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-bottom: -2%">
                            <div class="form-group row gutters">
                                <label for="inputName" class="col-sm-4 col-form-label text-left">Cari Data</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm"  id="search_on_modal"  name="search_on_modal">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group row gutters">
                                <label for="inputName" class="col-sm-4 col-form-label text-left">Tampilkan</label>
                                <div class="col-sm-8">
                                    <?=cbodisplay_on_modal();?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="table_search" class="table m-0 dataTable no-footer nowrap" style="width: 100%">
                            <thead>
                                <tr>
                                    <?php for ($no = 0; $no < count($judul_table); $no++) { ?>
                                    <?php echo  '<th>' . $judul_table[$no] . '</th>'; ?>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>                                     
                            </tbody>
                    </table>
                    </div>
                    <input type="hidden" id="param_form" name="param_form" value="<?php echo $param_form; ?>">
                    <input type="hidden" id="param_db" name="param_db" value="<?php echo $param_db; ?>">
                    <input type="hidden" id="param_data" name="param_data" value="<?php echo $param_data; ?>">
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var table_search;
    $('#search_on_modal').on('keyup',function () {
        table_search.search(this.value).draw();
    });
    
    $("#cbodisplay_on_modal").change(function() {
        table_search.page.len(this.value).draw();
    });
    
    $('#modal_formsearch').on('shown.bs.modal', function () {
       table_search = $('#table_search').DataTable();
       table_search.columns.adjust();
    });

    $(document).ready(function() {
        table_search = $('#table_search').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "searching": true,
            "ordering": true,
            "scrollX": true,
            "scrollY": "200px",
            "scrollCollapse": true,
            "info": true,
            "lengthMenu": [[10, 25, 50,100, 1000], [10, 25, 50,100, 1000]],
            "pageLength": 10,
            "bLengthChange": true,
            "pagingType" : "full",

            "ajax": {
                "url": "<?php echo site_url('search/table_search') ?>",
                "type": "POST",
                "data": function(data) {
                    data.param_form = $('#param_form').val();
                    data.param_db = $('#param_db').val();
                    data.param_data = $('#param_data').val();
                }

            },
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false
                }
                ,
                {
                    'targets'   : 1,
                    'render'    :   function (data, type, row) {
                        if($('#param_form').val() == "search_container_tpsonline" ){
                            return data.substr(0, 4)+" "+data.substr(4, 7);
                        }else{
                            return data;
                        }
                    }
                }
            ]
        });

        $('#table_search tbody').on('click', 'tr', function() {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                table_search.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

         $('#table_search tbody').on('dblclick', 'tr', function() {
             var param_form = $('#param_form').val();
             var param_db = $('#param_db').val();
             var data = table_search.row(this).data();
             
             if (param_form == "search_nmimportir") {
                    var nmimportir = data[1];
                    $('#modal_formsearch').modal('hide');                
                    document.getElementById('nmimportir').value = nmimportir;
             }else if(param_form == "search_container_tpsonline"){
                    var container = data[1];
                    var pid = data[0];
                    
                    url = '<?php echo site_url('search/getdata') ?>';
                    data = {pid:pid,param_form:param_form,param_db:param_db};
                    pesan = 'JavaScript Getdata Error...';
                    dataok = multi_ajax_proses(url, data, pesan);
                    
                    $('#code_principal').val(dataok['array_data']['code_principal']);
                    $('#name_principal').val(dataok['array_data']['name_principal']);
                    
                    if(dataok['array_data']['UK_CONT'] == "20"){
                        $('#reff_code').val('2DS');
                        $('#reff_description').val('20ft D.S');
                    }else{
                        $('#reff_code').val('4DS');
                        $('#reff_description').val('40ft D.S');
                    }
                    
                    $('#vessel').val(dataok['array_data']['NM_ANGKUT']+" "+dataok['array_data']['NO_VOY_FLIGHT']);
                    
                    $('#cont_number').val(container.substr(0, 4)+" "+container.substr(4, 7));
           
                    $('#modal_formsearch').modal('hide');    

             }else if(param_form == "search_no_transaksi"){
                
                var Do_Number = data[0];
                var cont_number = data[1];
                var No_Transaksi = data[2];

                //alert(No_Transaksi);
                

                url = '<?php echo site_url('search/getdata') ?>';
                data = {cont_number:cont_number,Do_Number:Do_Number,No_Transaksi:No_Transaksi,param_form:param_form,param_db:'ptmsagate'};
                pesan = 'JavaScript Getdata Error...';
                dataok = multi_ajax_proses(url, data, pesan);

                console.log(dataok);             

                if(dataok.msg != "Ya"){
                    alert('Data Tidak DiTemukan...');
                    return false;
                }     

                if(dataok['array_data']['code_principal'] == "TPP" || dataok['array_data']['code_principal'] == "PJT" || dataok['array_data']['code_principal']=="TPS"){
                    url = '<?php echo site_url('search/cek_lock_gate') ?>';
                    data = {cont_number:dataok['array_data']['cont_number'],code_principal:dataok['array_data']['code_principal'],cont_date_in:dataok['array_data']['cont_date_in']};
                    pesan = 'JavaScript cek_lock_gate Error...';
                    dataok1 = multi_ajax_proses(url, data, pesan);

                    console.log(dataok1);             

                    if(dataok1.msg != "Ya"){
                        alert(dataok1.pesan);
                        return false;
                    }


                    url = '<?php echo site_url('search/cek_lock_segel') ?>';
                    data = {cont_number:dataok['array_data']['cont_number'],code_principal:dataok['array_data']['code_principal'],cont_date_in:dataok['array_data']['cont_date_in']};
                    pesan = 'JavaScript cek_lock_segel Error...';
                    dataok2 = multi_ajax_proses(url, data, pesan);

                    console.log(dataok2);             

                    if(dataok2.msg != "Ya"){
                        alert(dataok2.pesan);
                        return false;
                    }
                }


                // if(dataok['array_data']['code_principal'] == "TPP" || dataok['array_data']['code_principal'] == "PJT" || dataok['array_data']['code_principal']=="TPS"){
                //     url = '<?php echo site_url('search/cek_lock_segel') ?>';
                //     data = {cont_number:dataok['array_data']['cont_number'],code_principal:dataok['array_data']['code_principal'],cont_date_in:dataok['array_data']['cont_date_in']};
                //     pesan = 'JavaScript cek_lock_segel Error...';
                //     dataok2 = multi_ajax_proses(url, data, pesan);

                //     console.log(dataok2);             

                //     if(dataok2.msg != "Ya"){
                //         alert(dataok2.pesan);
                //         return false;
                //     }
                // }
                    

                $('#No_Transaksi').val(No_Transaksi);
                $('#cont_number').val(dataok['array_data']['cont_number']);
                $('#code_principal').val(dataok['array_data']['code_principal']);
                $('#name_principal').val(dataok['array_data']['name_principal']);
                $('#reff_code').val(dataok['array_data']['reff_code']);
                $('#reff_description').val(dataok['array_data']['reff_description']);
                $('#cont_date_in').val(dataok['array_data']['cont_date_in2']);
                $('#vessel').val(dataok['array_data']['vessel']);
                $('#seal_number').val(dataok['array_data']['seal_number']);
                $('#notes').val(dataok['array_data']['notes']);
                $('#cont_condition').val(dataok['array_data']['cont_condition']);
                $('#cont_status').val(dataok['array_data']['cont_status']);
                $('#loc_block').val(dataok['array_data']['block_loc']);
                $('#loc_row').val(dataok['loc_row']);
                $('#loc_col').val(dataok['loc_col']);
                $('#loc_stack').val(dataok['loc_stack']);
                $('#ship_line_code').val(dataok['array_data']['ship_line_code']);
                $('#ship_line_name').val(dataok['array_data']['ship_line_name']);
                $('#notes').val(dataok['array_data']['notes']);
                $('#shipper').val(dataok['shipper']);


                // $('#r_party').val(dataok['r_party']);
                // $('#party').val(dataok['party']);

                $('#modal_formsearch').modal('hide'); 


             }else if(param_form == "search_container_stock"){
             
                var Do_Number = $('#param_data').val();
                var cont_number = data[1];
                var id_cont_in = data[0];

                url = '<?php echo site_url('search/getdata') ?>';
                data = {cont_number:cont_number,Do_Number:Do_Number,id_cont_in:id_cont_in,param_form:param_form,param_db:'ptmsagate'};
                pesan = 'JavaScript getdata Error...';
                dataok = multi_ajax_proses(url, data, pesan);

                console.log(dataok);  


                if(dataok['array_data']['code_principal'] == "TPP" || dataok['array_data']['code_principal'] == "PJT" || dataok['array_data']['code_principal']=="TPS"){
                    url = '<?php echo site_url('search/cek_lock_gate') ?>';
                    data = {cont_number:dataok['array_data']['cont_number'],code_principal:dataok['array_data']['code_principal'],cont_date_in:dataok['array_data']['cont_date_in']};
                    pesan = 'JavaScript cek_lock_gate Error...';
                    dataok1 = multi_ajax_proses(url, data, pesan);

                    console.log(dataok1);             

                    if(dataok1.msg != "Ya"){
                        alert(dataok1.pesan);
                        return false;
                    }

                    url = '<?php echo site_url('search/cek_lock_segel') ?>';
                    data = {cont_number:dataok['array_data']['cont_number'],code_principal:dataok['array_data']['code_principal'],cont_date_in:dataok['array_data']['cont_date_in']};
                    pesan = 'JavaScript cek_lock_segel Error...';
                    dataok2 = multi_ajax_proses(url, data, pesan);

                    console.log(dataok2);             

                    if(dataok2.msg != "Ya"){
                        alert(dataok2.pesan);
                        return false;
                    }
                }

                // if(dataok['array_data']['code_principal'] == "TPP" || dataok['array_data']['code_principal'] == "PJT" || dataok['array_data']['code_principal']=="TPS"){
                //     url = '<?php echo site_url('search/cek_lock_segel') ?>';
                //     data = {cont_number:dataok['array_data']['cont_number'],code_principal:dataok['array_data']['code_principal'],cont_date_in:dataok['array_data']['cont_date_in']};
                //     pesan = 'JavaScript cek_lock_segel Error...';
                //     dataok2 = multi_ajax_proses(url, data, pesan);

                //     console.log(dataok2);             

                //     if(dataok2.msg != "Ya"){
                //         alert(dataok2.pesan);
                //         return false;
                //     }
                // }

                $('#cont_number').val(dataok['array_data']['cont_number']);
                $('#code_principal').val(dataok['array_data']['code_principal']);
                $('#name_principal').val(dataok['array_data']['name_principal']);
                $('#reff_code').val(dataok['array_data']['reff_code']);
                $('#reff_description').val(dataok['array_data']['reff_description']);
                $('#cont_date_in').val(dataok['array_data']['cont_date_in2']);
                $('#vessel').val(dataok['array_data']['vessel']);
                $('#seal_number').val(dataok['array_data']['seal_number']);
                $('#notes').val(dataok['array_data']['notes']);
                $('#cont_condition').val(dataok['array_data']['cont_condition']);
                $('#cont_status').val(dataok['array_data']['cont_status']);
                $('#loc_block').val(dataok['array_data']['block_loc']);
                $('#loc_row').val(dataok['loc_row']);
                $('#loc_col').val(dataok['loc_col']);
                $('#loc_stack').val(dataok['loc_stack']);
                $('#ship_line_code').val(dataok['array_data']['ship_line_code']);
                $('#ship_line_name').val(dataok['array_data']['ship_line_name']);
                $('#notes').val(dataok['array_data']['notes']);
                $('#shipper').val(dataok['shipper']);


                // $('#r_party').val(dataok['r_party']);
                // $('#party').val(dataok['party']);

                $('#modal_formsearch').modal('hide'); 

             }

         });
    });
    
    $('#modal_formsearch').on('hidden.bs.modal', function() {
        var param_form = $('#param_form').val();
        if (param_form == "search_nmimportir") {            
            $('#nocontainer').focus();
        }else if(param_form == "search_container_tpsonline"){
            $('#truck_number').focus();        
        }else if(param_form == "search_no_transaksi" || param_form == "search_container_stock"){
            $('#truck_number').focus();     
        }

    });

</script>