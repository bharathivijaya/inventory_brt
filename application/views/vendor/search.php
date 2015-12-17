<h2>Search Results</h2>

<?if (!empty($vendors)){?>
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
        <td></td>
    </tr>
    </thead>
    <tbody>
    <?foreach ($vendors as $one) {?>
        <tr>
            <td><a href="/vendor/view_vendor/<?=$one['v_id']?>"><?=$one['v_name']?></a></td>
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
            <td><a href="/vendor/add_vendor/<?=$one['v_id']?>">Edit</a></td>
        </tr>
    <?}?>
    </tbody>
</table>
<?} else {?>
    <div class="error">
        There are no vendors under these conditions.
    </div>
<?}?>

