<h2>Banners</h2>

<!--<a href="<?=base_url()?>admin/add_banner" class="btn btn-info">New Banner</a>-->

<table class="table table-striped" id="myTable">
    <thead>
    <tr>
        <td>Name</td>
        <td>Layout</td>
        <td>Location</td>
        <td>Image</td>
        <td>Status</td>
        <td>Action</td>

    </tr>
    </thead>
    <tbody>
    <?foreach ($banners as $one) {?>
    <tr>
        <td><?=$one['b_name']?></td>
        <td><?=$one['b_layout']?></td>
        <td><?=$one['b_location']?></td>
        <td><?=$one['b_image']?></td>
        <td><?=$one['b_status']?></td>
        <td>
            <a href="<?=base_url()?>admin/add_banner/<?=$one['b_id']?>">Edit</a> |
            <a href="#" onclick="event.stopPropagation();event.preventDefault();openModal(<?=$one['b_id']?>)">Delete</a>
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
                <h4 class="modal-title">Delete Banner</h4>
            </div>
            <div class="modal-body" >
                Are you sure you want to delete the banner?
            </div>
            <div class="modal-footer">

                <input type="hidden" id="delId">

                <button type="button" class="btn btn-danger" id="del" data-dismiss="modal">Delete</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    $(document).ready(function(){
        $('#myTable').DataTable();
        $('#myTable_filter').after('<div id="after_filter"><a href="<?=base_url()?>admin/add_banner" class="btn btn-info" style="line-height: 0.9">New banner</a></div>');
        $('#del').click(function(event){
            var Id = $('#delId').val();
            window.location ='<?=base_url()?>admin/delete_banner/'+Id;
        });
    });

    function openModal(Id){
        $('#delId').val(Id);
        $('#delConfirm').modal();
    }

</script>