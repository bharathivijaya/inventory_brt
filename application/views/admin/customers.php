<h2>Manage Users</h2>

<table class="table table-striped" id="myTable">
    <thead>
    <tr>
        <td>Business Name</td>
        <td>First Name</td>
        <td>Last Name</td>
        <td>Email</td>
        <td>Username</td>
        <td>NPI</td>
        <td>Account Status</td>
        <td>Feature Status</td>
        <td>Date Registered</td>
        <td>Edit</td>
    </tr>
    </thead>
    <tbody>
    <?foreach ($customers as $one) {?>
        <tr>
            <td><a href="<?=base_url()?>admin/view_customer/<?=$one['id']?>"><?=$one['cname']?></a></td>
            <td><?=$one['first_name']?></td>
            <td><?=$one['last_name']?></td>
            <td><?=$one['email']?></td>
            <td><?=$one['username']?></td>
            <td><?=$one['npi']?></td>
            <td><?if ($one['status'] == 'email_confirmed') {echo 'Active';} else {echo 'Inactive';}?></td>
            <td><?if ($one['payment_expiry'] == 0) {echo 'Nothing';} else {echo 'L';}?></td>
            <td><?=date('m-d-Y', $one['date_registered'])?></td>
            <td><a href="<?=base_url()?>admin/add_customer/<?=$one['id']?>">edit</a></td>
        </tr>
    <?}?>
    </tbody>
</table>

<script>
    $(document).ready(function(){
        $('#myTable').DataTable();
    });
</script>