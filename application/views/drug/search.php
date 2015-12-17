<h2>Search Results</h2>

<?if (!empty($drugs)){?>
<table class="table">
    <thead>
    <tr>
        <td>Name</td>
        <td>NDC Code</td>
        <td>Manufacturer</td>
        <td>Status</td>
    </tr>
    </thead>
    <tbody>
    <?foreach ($drugs as $one) {?>
        <tr>
            <td><a href="/drug/view_drug/<?=$one['d_id']?>"><?=$one['d_name']?></a></td>
            <td><?=$one['d_code']?></td>
            <td><?=$one['d_manufacturer']?></td>
            <td><?if ($one['d_status'] == 1){echo 'Active';} else{echo 'Inactive';}?></td>
        </tr>
    <?}?>
    </tbody>
</table>
<?} else {?>
    <div class="error">
        There are no drugs under these conditions.
    </div>
<?}?>

