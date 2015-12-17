<h2>Admin List</h2>
<a href="<?=base_url()?>admin/add_admin" class="btn btn-info">New admin</a>
<table class="table table-striped" id="myTable">
    <thead>
    <tr>
        <td>Name</td>
        <td>Username</td>
        <td>Email</td>
        <td>Status</td>
        <td>Action</td>
    </tr>
    </thead>
    <tbody>
    <?foreach ($users as $one) {?>
    <tr>
        <td><?=$one['first_name'].' '.$one['last_name']?></td>
        <td><?=$one['username']?></td>
        <td><?=$one['email']?></td>
        <td><?if ($one['status'] == 'deleted') {echo 'Deleted';} else {echo 'Active';}?></td>
        <td>
            <a href="<?=base_url()?>admin/add_admin/<?=$one['id']?>">Edit</a>
            <a href="#" onclick="event.stopPropagation();event.preventDefault();openModal(<?=$one['id']?>)"><?if ($one['status'] == 'deleted') {?>Activate<?} else {?> Delete <?}?></a>
        </td>
    </tr>
    <?}?>
    </tbody>
</table>

<div class="modal fade" id="delConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Change Status?</h4>
            </div>
            <div class="modal-body" >
                Are you sure you want to change status of this admin?
            </div>
            <div class="modal-footer">

                <input type="hidden" id="delId">

                <button type="button" class="btn btn-danger" id="del" data-dismiss="modal">Change</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    $(document).ready(function(){
         $('#del').click(function(event){
             var Id = $('#delId').val();
             window.location ='<?=base_url()?>admin/delete_admin/'+Id;
         });
    });

    function openModal(Id){
         $('#delId').val(Id);
         $('#delConfirm').modal();
    }
</script>