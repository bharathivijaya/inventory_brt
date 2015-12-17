<h2><?if (empty($drug)){echo 'New';} else {echo 'Edit';}?> Drug</h2>

<form action="" method="post" class="narrow " id="drugform">
    <? if (!empty($drug)) {?>
        <input type="hidden" name="d_id" value="<?=@$drug['d_id']?>" id="d_id">
    <?}?>
    <input type="hidden" name="add_new" value="0" id="success_or_new">
    <div class="form-group">
        <label>Name</label>
        <input type="text" id="d_name" name="d_name" value="<?=@$drug['d_name']?>" class="form-control uppercase">
    </div>

    <div class="form-group">
        <label>NDC Code</label>
        <input type="text" name="d_code" value="<?=@$drug['d_code']?>" class="form-control" id="ndc" data-mask="99999-9999-99"  <?if (($this->session->userdata('type') !== 'company')&& (!empty($drug))){?>disabled<?}?>>
    </div>

    <div class="form-group">
        <label>Description</label>
        <input type="text" name="d_descr" value="<?=@$drug['d_descr']?>" class="form-control uppercase">
    </div>
    <div class="form-group">
        <label>Package Size</label>
        <input type="text" name="d_size" value="<?=@$drug['d_size']?>" class="form-control" <?if (($this->session->userdata('type') !== 'company')&& (!empty($drug))){?>disabled<?}?>>
    </div>
    <div class="form-group">
        <label>Manufacturer</label>
        <input type="text" name="d_manufacturer" value="<?=@$drug['d_manufacturer']?>" class="form-control uppercase" required>
    </div>
    <div class="form-group">
        <label>Starting Inventory in Units</label>
        <input type="text" name="d_start" value="<?=@$drug['d_start']?>" class="form-control" <?if (!empty($drug)){?>readonly <?}?>>
    </div>
    <div class="form-group">
        <label>Schedule</label>
        <select name="d_schedule" class="form-control">
            <option value="" <?if (empty($drug)){?> selected <?}?>>Select Schedule</option>
            <option value="C1" <?if (@$drug['d_schedule'] == 'C1'){echo 'selected';}?>>C1</option>
            <option value="C2" <?if (@$drug['d_schedule'] == 'C2'){echo 'selected';}?>>C2</option>
            <option value="C3" <?if (@$drug['d_schedule'] == 'C3'){echo 'selected';}?>>C3</option>
            <option value="C4" <?if (@$drug['d_schedule'] == 'C4'){echo 'selected';}?>>C4</option>
            <option value="C5" <?if (@$drug['d_schedule'] == 'C5'){echo 'selected';}?>>C5</option>
            <option value="Legend" <?if (@$drug['d_schedule'] == 'Legend'){echo 'selected';}?>>Legend</option>
            <option value="OTC" <?if (@$drug['d_schedule'] == 'OTC'){echo 'selected';}?>>OTC</option>
        </select>
    </div>
    <div class="form-group">
        <label>Barcode</label>
        <input type="text" name="d_barcode" value="<?=@$drug['d_barcode']?>" class="form-control uppercase">
    </div>
    <div class="form-group">
        <label>Status</label>
        <select name="d_status" class="form-control">
            <option value="" <?if (isset($drug)){?> selected <?}?>>Select Status</option>
            <option value="1" <?if (@$drug['d_status'] == 1){?> selected <?}?>>Active</option>
            <option value="0" <?if (@$drug['d_status'] === '0'){?> selected <?}?>>Inactive</option>
        </select>
    </div>

    <div class="form-group">
        <label style="width: 100%">Category <a href="javascript://void();" onclick="openModal();" class="btn btn-info btn-sm" style="float: right">New category</a></label>
		<div id="jstree"></div>
		<input name="d_catId" id="d_catId" type="hidden" value="<?= @$drug['d_catId'] ?>" />
    </div>

    <input type="button" value="Clear" class="btn btn-danger" id="reset">
    <input type="submit" value="Save" class="btn btn-primary" id="save_success">
    <input type="submit" value="Save & add New" class="btn btn-success" id="save_new">
</form>

<div class="modal fade" id="addNewCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Add new category</h4>
			</div>
			<div class="modal-body">
				<form action="" method="post" class="middle" id="catForm">
					<div class="form-group">
						<label>Category Name - <a href="javascript://void();" onclick="copyDrugName();">Copy Drug Name</a></label>
						<input type="text" id="c_name" name="c_name" value="" class="form-control">
					</div>
					<div class="form-group">
						<label>Description</label>
						<input type="text" name="c_descr" value="" class="form-control">
					</div>
					<div class="form-group">
						<label>Parent Category</label>
						<select name="c_mainCatId" class="form-control">
							<option value="0">Select Parent Category</option>
							<?if ($parentCats) foreach ($parentCats as $pcat) { ?>
								<option value="<?= $pcat["c_id"] ?>"><?= $pcat["c_name"] ?></option>
							<? } ?>
						</select>
					</div>
					<div class="form-group">
						<label>Category Status</label>
						<select id="c_status" name="c_status" class="form-control" required>
							<option value="" selected>Select Status</option>
							<option value="Active">Active</option>
							<option value="Inactive">Inactive</option>
						</select>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<input type="hidden" id="delId">
				<button type="button" class="btn btn-success" data-dismiss="modal" id="addNewCat">Add</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.1.1/jstree.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.1.1/themes/default/style.min.css" rel="stylesheet">

<script>
	var who_opened = {};

	$(document).ready(function(){
		$('#catForm').bootstrapValidator({
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			excluded: ':disabled',
			fields: {
				c_name: {
					message: 'Name can not be empty',
					validators: {
						notEmpty: {
							message: 'Name is required and cannot be empty'
						}
					}
				},
				c_status: {
					message: 'Status is not valid',
					validators: {
						notEmpty: {
							message: 'Status is required and cannot be empty'
						}
					}
				}
			}
		});

		$('#addNewCat').click(function(event){
			$("#catForm").submit();
		});

		$("#catForm").submit(function()
		{
			if (!$("#c_name").val() && !$("#c_status").val()) return false;

			$.ajax({
				type: "POST",
				url: "/category/add_category_by_js",
				cache: false,
				data: $("#catForm").serialize(),
				success: function(data)
				{
					reloadCatTree();
				},
				error: function(data)
				{
					console.log(data);
				}
			});

			return false;
		});
	});

	function copyDrugName()
	{
		$("#c_name").val($("#d_name").val());
	}

	function openModal()
	{
		$('#addNewCategory').modal();
	}

	function openOptGroup(id)
	{
		$.ajax({
			method: "POST",
			cache: false,
			url: "/drug/getChildrenCategoryJSON/" + id
		}).done(function(msg){
			if (who_opened[id]) return;

			var R = JSON.parse(msg);

			who_opened[id] = true;

			for (var i = 0; i < R.length; i++)
				$("#optgroup-" + id).after('<option value="' + R[i].c_id + '">|-- ' + R[i].c_name + '</option>');
		});
	}

	function reloadCatTree()
	{
		$.ajax({
			"url": "/drug/loadDrugCatsJSON",
			"method": "POST",
			"success": function(catsData)
			{
				var c_data = JSON.parse(catsData);

				$('#jstree').jstree(true).settings.core.data = c_data;
				$('#jstree').jstree(true).refresh();
			}
		});
	}

	function initTree()
	{
		$('#jstree').jstree({
			'core': {
				'data': <?= json_encode($cats); ?>
			},
            "checkbox" : {
                "three_state" : false
            },
            "plugins" : [ "checkbox" ]
		});

		$("#jstree").bind(
			"changed.jstree", function(evt, data){
				//console.log(data.selected);
				$("#d_catId").val(data.selected);
			}
		);
	}
</script>

<script>

    $('#ndc').keyup(function() {
		$('#drugform').bootstrapValidator('revalidateField', 'd_code');
	});

    $("#reset").click(function() {
        $(this).closest('form').find("input[type=text], textarea, select").val("");
    });

    function applyValidator(){
        $('#drugform').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            excluded: ':disabled',
            fields: {
                d_name: {
                    message: 'Name can not be empty',
                    validators: {
                        notEmpty: {
                            message: 'Name is required and cannot be empty'
                        }
                    }
                },
                d_code: {
                    message: 'NDC is not valid',
                    validators: {
                        remote: {
                            url: '<?=base_url()?>drug/check_ndc/',
                            data: function(validator) {
                                return {
                                    d_code: validator.getFieldElements('d_code').val(),
                                    d_id: validator.getFieldElements('d_id').val()
                                };
                            },
                            message: 'NDC is not available'
                        },
                        notEmpty: {
                            message: 'NDC is required and cannot be empty'
                        },
                        regexp: {
                            regexp: /^[0-9-]+$/,
                            message: 'NDC should consist of 11 numerical characters'
                        }

                    }
                },
                d_size: {
                    message: 'Size is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Size is required and cannot be empty'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'Size can only consist of numerical characters'
                        }
                    }
                },
                d_schedule: {
                    message: 'Schedule is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Schedule is required and cannot be empty'
                        }
                    }
                },
                d_start: {
                    message: 'Starting Inventory is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Starting Inventory is required and cannot be empty'
                        }
                    }
                },
                d_status: {
                    message: 'Status is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Status is required and cannot be empty'
                        }
                    }
                }
            }
        });
    }

    $(document).ready(function(){
        applyValidator();
        $('#save_new').mousedown(function(){
            $('#success_or_new').val(1);
        });
        $('#save_success').mousedown(function(){
            $('#success_or_new').val(0);
        });

		initTree();
	});


</script>