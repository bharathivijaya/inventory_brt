<h2>Reports</h2>

<form action="<?=base_url()?>admin/generate_report" method="post" class="narrow">
    <select name="type" class="form-control" id="selectType">
        <option value="">Select report type</option>
        <option value="users">Active/Inactive Users</option>
        <option value="sales">Sales</option>
        <option value="customers">Customers</option>
    </select>

    <div class="form-group" id="users">
        <div class="radio">
            <input type="radio" name="users" value="active" checked> Active
        </div>
        <div class="radio">
            <input type="radio" name="users" value="inactive"> Inactive
        </div>
    </div>

    <div class="form-group" id="sales">

    </div>

    <div class="form-group" id="customers">
        <!--<div class="radio">
            <input type="radio" name="customers" value="free" checked> Free trial users
        </div>-->
        <div class="radio">
            <input type="radio" name="customers" value="Monthly"> Monthly users
        </div>
        <div class="radio">
            <input type="radio" name="customers" value="Annual" > Annual users
        </div>
    </div>

    <input type="submit" value="Continue" class="btn btn-primary" disabled id="submit">
</form>

<script>
    $(document).ready(function() {
        $('#users').hide();
        $('#sales').hide();
        $('#customers').hide();
    });

    $('#selectType').change(function(){
        var type = $(this).val();
        if (type == 'users') {
            $('#users').show();
            $('#sales').hide();
            $('#customers').hide();
            $('#submit').attr('disabled', false)
        }
        else if (type == 'sales') {
            $('#users').hide();
            $('#sales').show();
            $('#customers').hide();
            $('#submit').attr('disabled', false)
        }
        else if (type == 'customers') {
            $('#users').hide();
            $('#sales').hide();
            $('#customers').show();
            $('#submit').attr('disabled', false)
        }
        else {
            $('#users').hide();
            $('#sales').hide();
            $('#customers').hide();
            $('#submit').attr('disabled', true)
        }
    });

</script>