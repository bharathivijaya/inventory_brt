<?php
/**
 * Created by PhpStorm.
 * User: Tan4ik
 * Date: 24.03.15
 * Time: 21:44
 */
?>
<h2>My users</h2>
<a href="<?=base_url()?>user/add_user" class="btn btn-info">New User</a>
<table class="table">
    <thead>
    <tr>
        <td>First Name</td>
        <td>Last Name</td>
        <td>Role</td>
        <td>License Number</td>
        <td>License Expiry</td>
        <td>Username</td>
        <td>Alerts</td>
        <td>Reports</td>
        <td colspan="2">Actions</td>
    </tr>
    </thead>
    <tbody>
    <?foreach($users as $usr){?>
    <tr>

        <td><a href="<?=base_url()?>user/view_user/<?=$usr['id']?>"><?=$usr['first_name']?></a></td>
        <td><?=$usr['last_name']?></td>
        <td><?=$usr['role']?></td>
        <td><?=$usr['license_number']?></td>
        <td><?=date('m-d-Y', $usr['license_expiry'])?></td>
        <td><?=$usr['username']?></td>
        <td><?=$usr['alerts']?></td>
        <td><?=$usr['reports']?></td>

        <td><a href="<?=base_url()?>user/add_user/<?=$usr['id']?>">Edit</a> </td>
        <!--<td><a href="javascript://void()" onclick="removeUser(<?=$usr['id']?>);">Delete</a> </td>-->
       	<td><a href="javascript://void()" onclick="event.stopPropagation();event.preventDefault();openModal(<?=$usr['id']?>)">Delete</a> </td>

    </tr>
    <?}?>
    </tbody>
</table>

<div class="modal fade" id="delConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Remove this user?</h4>
			</div>
			<div class="modal-body" >
				Are you sure you want to remove this user?
			</div>
			<div class="modal-footer">

				<input type="hidden" id="delId">

				<button type="button" class="btn btn-danger" id="del" data-dismiss="modal">Remove</button>
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
			var id = $('#delId').val();
			window.location = "/user/delete_user/" + id;
		});
	});

	function openModal(Id){
		$('#delId').val(Id);
		$('#delConfirm').modal();
	}
	/*function removeUser(id)
	{
		if (confirm("Are you sure you want to remove this user?"))
			window.location = "/user/delete_user/" + id;
	}*/
</script>