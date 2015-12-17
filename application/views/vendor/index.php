<h2>Vendor List</h2>

<!--
<h3>Search</h3>
<form action="/vendor/search" method="post" class="form-inline">

    <div class="form-group">
        <select name="criterion" class="form-control">
            <option value="v_name">Name</option>
            <option value="v_address">Address</option>
            <option value="v_city">City</option>
            <option value="v_state">State</option>
            <option value="v_zip">Zipcode</option>
            <option value="v_tel">Tel</option>
            <option value="v_fax">Fax</option>
            <option value="v_email">Email</option>
            <option value="v_license">License Number</option>
            <option value="v_dea">DEA</option>
            <option value="v_cname">Contact Name</option>
            <option value="v_status">Status</option>
        </select>
    </div>
    <div class="form-group">
        <input type="text" name="value" class="form-control" placeholder="Enter value">
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>-->

<table class="table table-striped" id="myTable">
    <thead>
    <tr>
        <td>Name</td>
        <td>Address</td>
        <td>City</td>
        <td>State</td>
        <td>Zipcode</td>
        <td>Tel</td>
        <td>Fax</td>
        <td>Email</td>
        <td>License Number</td>
        <td>DEA</td>
        <td>Contact Name</td>
        <td>Status</td>
        <td></td>
    </tr>
    </thead>
    <tbody>
    <?foreach ($vendors as $one) {?>
    <tr>
        <td><a href="<?=base_url()?>vendor/view_vendor/<?=$one['v_id']?>"><?=$one['v_name']?></a></td>
        <td><?=$one['v_address']?></td>
        <td><?=$one['v_city']?></a></td>
        <td><?=$one['v_state']?></td>
        <td><?=$one['v_zip']?></td>
        <td><?=$one['v_tel']?></td>
        <td><?=$one['v_fax']?></a></td>
        <td><?=$one['v_email']?></td>
        <td><?=$one['v_license']?></td>
        <td><?=$one['v_dea']?></a></td>
        <td><?=$one['v_cname']?></td>
        <td><?=$one['v_status']?></td>
        <td><a href="<?=base_url()?>vendor/add_vendor/<?=$one['v_id']?>">Edit</a></td>
    </tr>
    <?}?>
    </tbody>
</table>

<script>
    $(document).ready(function(){
        $('#myTable').DataTable();
        $('#myTable_filter').after('<div id="after_filter"><a href="<?=base_url()?>vendor/add_vendor" class="btn btn-warning" style="line-height: 0.9">New vendor</a></div>');
    });
</script>