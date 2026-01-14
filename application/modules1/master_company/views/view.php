<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Master</li>
        <li class="breadcrumb-item active">..::: Master Company :::..</li>
    </ol>
</div>

<div class="content-wrapper">
    <div class="row justify-content-center gutters">
        <div class="col-xl-7 col-lg-7 col-md-9 col-sm-10">
            <form role="form" id="submit">
                <div class="card m-0">
                    <div class="card-body boxshadow">

                        <div class="form-group row gutters">
                            <label for="inputName" class="col-sm-3 col-form-label text-left">Company Name</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="company_name" name="company_name" value="<?=$array_data['company_name'];?>">
                            </div>
                        </div>

                        <div class="form-group row gutters">
                            <label for="inputName" class="col-sm-3 col-form-label text-left">Branch Name</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="branch_name" name="branch_name" value="<?=$array_data['branch_name'];?>">
                            </div>
                        </div>

                        <div class="form-group row gutters">
                            <label for="inputName" class="col-sm-3 col-form-label text-left">Branch Code</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="branch_code" name="branch_code" value="<?=$array_data['branch_code'];?>">
                            </div>
                        </div>

                        <div class="form-group row gutters">
                            <label for="inputName" class="col-sm-3 col-form-label text-left">Address</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="address" name="address" maxlength="140" rows="4"><?=$array_data['address'];?></textarea>
                            </div>
                        </div>

                        <div class="form-group row gutters">
                            <label for="inputName" class="col-sm-3 col-form-label text-left">Region</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="region" name="region" value="<?=$array_data['region'];?>">
                            </div>
                        </div>

                        <div class="form-group row gutters">
                            <label for="inputName" class="col-sm-3 col-form-label text-left">City</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="city" name="city" value="<?=$array_data['city'];?>">
                            </div>
                        </div>

                        <div class="form-group row gutters">
                            <label for="inputName" class="col-sm-3 col-form-label text-left">Telephone</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?=$array_data['no_telp'];?>">
                            </div>
                        </div>

                        <div class="form-group row gutters">
                            <label for="inputName" class="col-sm-3 col-form-label text-left">Faxcimile</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="no_fax" name="no_fax" value="<?=$array_data['no_fax'];?>">
                            </div>
                        </div>
                        
                        <input type="hidden" class="form-control" id="id_company" name="id_company" value="<?=$array_data['id_company'];?>">
                        
                        <button type="submit" class="btn btn-primary float-right"><b><span class="icon-save2"></span>Save</b></button>

                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script src="<?= site_url(); ?>assets/js/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
 
        $('#submit').submit(function(e){
            e.preventDefault();             
            url = '<?php echo site_url('master/company/save') ?>';
            data = new FormData(this);
            pesan = 'JavaScript Save Error...';
            dataok = submit_ajax_proses(url, data, pesan);
//            console.log(dataok);
            if(dataok.msg != 'Ya'){
                alert(dataok.pesan);
                return false;
            }

            alert(dataok.pesan);
        
            $('#id_company').val(dataok.id_company);            
        });
    });
</script>