<?php

include('function.php');

?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <link rel="stylesheet" type="text/css" href="library/jstable.css" />

        <script src="library/jstable.min.js" type="text/javascript"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="library/jstable.css" />

        <script src="library/jstable.min.js" type="text/javascript"></script>
        <title>Vanilla</title>
    </head>
    <body>

        <div class="container">
            <h1 class="mt-5 mb-5 text-center text-danger">
            <b>Vanilla - 2 DataTables for Hass Lii Pro</b></h1>

            <span id="success_message"></span>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col col-md-6">Customer Data</div>
                        <div class="col col-md-6" align="right">
                            <button type="button" name="add_data" id="add_data" class="btn btn-success btn-sm">Add</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="customer_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Gender</th>
                                    <th>Age</th>
                                    <th>Region</th>
                                    <th>District</th>
                                    <th>Shehia</th>
                                    <th>File No</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo fetch_top_five_data($connect); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>


<div class="modal" id="customer_modal" tabindex="-1">
    <form method="post" id="customer_form">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="modal_title">Add Customer</h5>

                    <button type="button" class="btn-close" id="close_modal" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">
                 <label class="form-label">File No.</label>
                <input type="text" name="ir_number" id="ir_number" class="form-control" />
                <span class="text-danger" id="ir_error"></span>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" name="fullname" id="fullname" class="form-control" />
                        <span class="text-danger" id="fullname_error"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Age</label>
                        <input type="text" name="age" id="age" class="form-control" />
                        <span class="text-danger" id="age_error"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" id="gender" class="form-control">
                        <option value="">--select gender--</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                      <span class="text-danger" id="gender_error"></span>
                    </div>
                    
                      <div class="mb-3">
                        <label class="form-label">Region</label>
                        <input type="text" name="region" id="region" class="form-control" />
                        <span class="text-danger" id="region_error"></span>
                    </div>
                    
                     <div class="mb-3">
                        <label class="form-label">District</label>
                        <input type="text" name="district" id="district" class="form-control" />
                        <span class="text-danger" id="district_error"></span>
                    </div>
                    
                     <div class="mb-3">
                        <label class="form-label">Shehia</label>
                        <input type="text" name="shehia" id="shehia" class="form-control" />
                        <span class="text-danger" id="shehia_error"></span>
                    </div>

                </div>

                <div class="modal-footer">

                    <input type="hidden" name="victim_id" id="victim_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <button type="button" class="btn btn-primary" id="action_button">Add</button>
                </div>

            </div>

        </div>

    </form>

</div>

<div class="modal-backdrop fade show" id="modal_backdrop" style="display:none;"></div>

<script>

var table = new JSTable("#customer_table", {
    serverSide : true,
    deferLoading : <?php echo count_all_data($connect); ?>,
    ajax : "fetch.php"
});

function _(element)
{
    return document.getElementById(element);
}

function open_modal()
{
    _('modal_backdrop').style.display = 'block';
    _('customer_modal').style.display = 'block';
    _('customer_modal').classList.add('show');
}

function close_modal()
{
    _('modal_backdrop').style.display = 'none';
    _('customer_modal').style.display = 'none';
    _('customer_modal').classList.remove('show');
}

function reset_data()
{
    _('customer_form').reset();
    _('action').value = 'Add';
    _('fullname_error').innerHTML = '';
    _('gender_error').innerHTML   = '';
    _('region_error').innerHTML   = '';
    _('district_error').innerHTML = '';
    _('shehia_error').innerHTML   = '';
    _('ir_error').innerHTML   = '';
    _('modal_title').innerHTML    = 'Add Data';
    _('action_button').innerHTML  = 'Add';
}

_('add_data').onclick = function(){
    open_modal();
    reset_data();
}

_('close_modal').onclick = function(){
    close_modal();
}

_('action_button').onclick = function(){

    var form_data = new FormData(_('customer_form'));

    _('action_button').disabled = true;

    fetch('action.php', {

        method:"POST",

        body:form_data

    }).then(function(response){

        return response.json();

    }).then(function(responseData){

        _('action_button').disabled = false;

        if(responseData.success)
        {
            _('success_message').innerHTML = responseData.success;

            close_modal();

            table.update();
        }
        else
        {
            if(responseData.fullname_error)
            {
                _('fullname_error').innerHTML = responseData.fullname_error;
            }
            else
            {
                _('fullname_error').innerHTML = '';
            }
            
            if(responseData.gender_error)
            {
                _('gender_error').innerHTML = responseData.gender_error;
            }
            else
            {
                _('gender_error').innerHTML = '';
            }

            if(responseData.age_error)
            {
                _('age_error').innerHTML = responseData.age_error;
            }
            else
            {
                _('age_error').innerHTML = '';
            }

            if(responseData.region_error)
            {
                _('region_error').innerHTML = responseData.region_error;
            }
            else
            {
                _('region_error').innerHTML = '';
            }
            
            
            if(responseData.district_error)
            {
                _('district_error').innerHTML = responseData.district_error;
            }
            else
            {
                _('district_error').innerHTML = '';
            }
            
            if(responseData.shehia_error)
            {
                _('shehia_error').innerHTML = responseData.shehia_error;
            }
            else
            {
                _('shehia_error').innerHTML = '';
            }
            
           if(responseData.ir_error)
            {
                _('ir_error').innerHTML = responseData.ir_error;
            }
            else
            {
                _('ir_error').innerHTML = '';
            }
        }

    });

}

function fetch_data(id)
{
    var form_data = new FormData();

    form_data.append('id', id);

    form_data.append('action', 'fetch');

    fetch('action.php', {

        method:"POST",

        body:form_data

    }).then(function(response){

        return response.json();

    }).then(function(responseData){


        
        _('fullname').value = responseData.fullname;

        _('gender').value  = responseData.gender;

        _('age').value     = responseData.age;

        _('region').value  = responseData.region;
        
        _('district').value  = responseData.district;
        
        _('shehia').value  = responseData.shehia;
        
        _('ir_number').value  = responseData.ir_number;

        _('victim_id').value = id;

        _('action').value = 'Update';

        _('modal_title').innerHTML = 'Edit Data';

        _('action_button').innerHTML = 'Edit';

        open_modal();

    });
}

function delete_data(id)
{
    if(confirm("Are you sure you want to remove it?"))
    {
        var form_data = new FormData();

        form_data.append('id', id);

        form_data.append('action', 'delete');

        fetch('action.php', {

            method:"POST",

            body:form_data

        }).then(function(response){

            return response.json();

        }).then(function(responseData){

            _('success_message').innerHTML = responseData.success;

            table.update();

        });
    }
}

</script>
