<h2><?=$vendor['v_name']?></h2>

<a href="<?=base_url()?>vendor/add_vendor/<?=$vendor['v_id']?>" class="btn btn-primary">Edit vendor</a>

<table class="table">
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
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?=$vendor['v_name']?></a></td>
        <td><?=$vendor['v_address']?></td>
        <td><?=$vendor['v_city']?></a></td>
        <td><?=$vendor['v_state']?></td>
        <td><?=$vendor['v_zip']?></td>
        <td><?=$vendor['v_tel']?></td>
        <td><?=$vendor['v_fax']?></a></td>
        <td><?=$vendor['v_email']?></td>
        <td><?=$vendor['v_license']?></td>
        <td><?=$vendor['v_dea']?></a></td>
        <td><?=$vendor['v_cname']?></td>
        <td><?=$vendor['v_status']?></td>
    </tr>
    </tbody>
</table>
