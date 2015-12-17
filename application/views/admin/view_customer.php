<h2>View <?=$user['username']?></h2>

<div class="row">
    <h3>Company info</h3>
</div>

<table class="table">
    <tbody>
    <tr>
        <td>Company Name</td>
        <td><?=$user['cname']?></td>
    </tr>
    <tr>
        <td>Company Address</td>
        <td><?=$user['caddress']?></td>
    </tr>
    <tr>
        <td>City</td>
        <td><?=$user['ccity']?></td>
    </tr>
    <tr>
        <td>State</td>
        <td><?=$user['cstate']?></td>
    </tr>
    <tr>
        <td>Zipcode</td>
        <td><?=$user['czip']?></td>
    </tr>
    <tr>
        <td>Company Tel</td>
        <td><?=$user['ctel']?></td>
    </tr>
    <tr>
        <td>Company Fax</td>
        <td><?=$user['cfax']?></td>
    </tr>
    <tr>
        <td>Contact Name</td>
        <td><?=$user['first_name'].' '.$user['last_name']?></td>
    </tr>
    <tr>
        <td>Contact Number</td>
        <td><?=$user['contact_number']?></td>
    </tr>
    <tr>
        <td>Username</td>
        <td><?=$user['username']?></td>
    </tr>
    <tr>
        <td>NPI</td>
        <td><?=$user['npi']?></td>
    </tr>
    </tbody>
</table>

<div class="row">
    <a href="<?=base_url()?>admin/add_customer/<?=$user['id']?>" class="btn btn-primary">Edit Info</a>
</div>



