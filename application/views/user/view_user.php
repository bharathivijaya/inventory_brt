<h2><?=$user['username']?></h2>

<table class="table">
    <?if ($user['status'] == 'deleted') {?>
        <thead>
        <tr>
            <td colspan="2" class="deleted">Deleted User</td>
        </tr>
        </thead>
    <?}?>
    <tbody>
    <tr>
        <td>First Name</td>
        <td><?= $user['first_name']?></td>
    </tr>
    <tr>
        <td>Last Name</td>
        <td><?= $user['last_name']?></td>
    </tr>
    <?if (($this->session->userdata('type') !== 'admin') && ($this->session->userdata('type') !== 'super')) {?>
    <tr>
        <td>Role</td>
        <td><?= $user['role']?></td>
        </tr>
    <tr>
        <td>License Number</td>
        <td><?= $user['license_number']?></td>
        </tr>
    <tr>
        <td>License Expiry</td>
        <td><?=date('m-d-Y', $user['license_expiry'])?></td>
    </tr>
    <?}?>
    <tr>
        <td>Username</td>
        <td><?= $user['username']?><br></td>
    </tr>
    <tr>
        <td>Email</td>
        <td><?= $user['email']?><br></td>
    </tr>
    <?if (($this->session->userdata('type') !== 'admin') && ($this->session->userdata('type') !== 'super')) {?>
    <tr>
        <td>Reports</td>
        <td><?= $user['reports']?><br></td>
    </tr>
    <?}?>

    </tbody>

</table>
<?if ($this->session->userdata('id') !== $user['id']) {?>
<a href="<?=base_url()?>user/add_user/<?=$user['id']?>" class="btn btn-info">Edit User</a>
<?} else {?>
<a href="<?=base_url()?>user/change_password" class="btn btn-info">Change password</a>
<?}?>
<?if (($this->session->userdata('type') == 'admin') || ($this->session->userdata('type') == 'super')) {?>
    <a href="<?=base_url()?>user/change_email" class="btn btn-success">Change email</a>
<?}?>

