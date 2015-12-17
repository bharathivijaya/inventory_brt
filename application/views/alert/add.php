<h2><?if (empty($alert)) echo 'New'; else echo 'Edit'; ?> Alert</h2>

<?php 
if ($form_errors != "") {	
	?>
	<div class="alert alert-danger" role="alert"><?php echo $form_errors;?></div>
	<?php 
}
?>

<form class="narrow" style="width: 320px;">
	<div class="form-group">
		<label>Select alert type</label>
		<select id="alertType" onchange="changeForms(this.value)" class="form-control">
			<option value="Audit" <?if (empty($alert)) { ?> selected <? } ?>>Audit</option>
			<option value="Inventory" <?if (@$alert['alertType'] == 'Inventory') echo 'selected';?>>Inventory</option>
		</select>
	</div>
</form>

<form action="" method="post" class="narrow" id="audit_form" style="display: block; width: 320px;">
	<input type="hidden" name="alertRealType" value="Audit" />
	<input type="hidden" name="alertRealId" value="<?= @$alert['id'] ?>" />

	<div class="form-group">
		<label>Audit Frequency *</label>
		<div class="input-group">
			<input type="text" id="auditFrequency" data-bind="value:replyNumber" onkeyup="valNumber('#auditFrequency');" name="auditFrequency" value="<? if (@$alert['auditFrequency']) echo $alert['auditFrequency']; else echo 30;  ?>" class="form-control">
     		<span class="input-group-btn">
        		<button class="btn btn-default" type="button" onclick="fieldNumberChange('#auditFrequency', '--', 1, 365)">-</button>
        		<button class="btn btn-default" type="button" onclick="fieldNumberChange('#auditFrequency', '++', 1, 365)">+</button>
      		</span>
			   Days
		</div>
	</div>

	<div class="form-group">
		<label>Status *</label>
		<select name="alertStatus" class="form-control">
			<option value="1">On</option>
			<option value="0" <?if (@$alert['alertStatus'] == 0) echo 'selected'; ?>>Off</option>
		</select>
	</div>

	<div class="form-group">
		<label>Audit Time *</label>
		<input type="text" name="auditTime" required="" value="<? if (@$alert['auditTime']) echo $alert["auditTime"]; else echo "00:00:00"; ?>" class="form-control">
	</div>

	<div class="form-group">
		<label>Audit Start Date *</label>
		<input type="text" name="auditStartDate" required="" value="<?if (@$alert['auditStartDate']) echo date("m/d/Y", $alert['auditStartDate']); else echo date("m/d/Y", time()); ?>" class="form-control dateTimeField">
	</div>

	<div class="form-group">
		<label>Audit End Date</label>
		<input type="text" name="auditEndDate" value="<? if (@$alert['auditEndDate'] > 0) @date("m/d/Y", $alert['auditEndDate']) ?>" class="form-control dateTimeField">
	</div>

	<div class="form-group">
		<label>Alert Triggers</label>
		<div class="checkbox">
			<label>
				<input name="auditNegativeInventory" value="1" type="checkbox" <?if (@$alert['negativeInventory'] == 'On') echo 'checked'; ?>> Negative Inventory
			</label>
		</div>
		<div class="checkbox">
			<label>
				<input id="quantityLimit" name="quantityLimit" onchange="switchQuantityFields();" value="1" type="checkbox" <?if (@$alert['quantityLimit'] == 'On') echo 'checked'; ?>> Quantity Limit
			</label>
		</div>
	</div>

	<div class="form-group">
		<label>Quantity Limit</label>
		<input type="text" id="lessThen" name="lessThen" disabled value="<?= @$alert['lessThan'] ?>" placeholder="Enter Quantity Less Than or Equal To" class="form-control">
		<input type="text" id="greaterThen" name="greaterThen" disabled value="<?= @$alert['greaterThan'] ?>" placeholder="Enter Quantity Greater Than or Equal To" class="form-control">
	</div>

	<div class="form-group">
		<label>Select Product *</label>
		<input type="text" name="selectProduct" id="selectProduct" value="" class="form-control" placeholder="Search and Select">
		<div id="selectedProductList" style="margin-top: 10px; padding: 5px;"></div>
	</div>

	<div class="form-group">
		<input type="hidden" style="opacity: 0; height: 0; width: 0;" name="productListInventoryAudit" required="" id="productListInventoryAudit" />
	</div>

	<div class="form-group">
		<label>Force Audit</label>
		<select name="auditForce" class="form-control">
			<option value="On">On</option>
			<option value="Off" <?if (@$alert['forceAudit'] == 'Off') echo 'selected'; ?>>Off</option>
		</select>
	</div>

	<div class="form-group">
		<label>Reschedule Audit After Last Audit</label>
		<select name="auditReschedule" class="form-control">
			<option value="On">On</option>
			<option value="Off" <?if (@$alert['rescheduleAuditAfterLastAudit'] == 'Off') echo 'selected'; ?>>Off</option>
		</select>
	</div>

	<input type="button" value="Clear" class="btn btn-danger btnReset">
	<input type="submit" value="Confirm" class="btn btn-primary" name="save_success" id="save_success">
	<input type="submit" value="Confirm & Add Another" class="btn btn-success" name="save_new" id="save_new">
</form>

<form action="" method="post" class="narrow" id="inventory_from" style="display: none; width: 320px;">
	<input type="hidden" name="alertRealType" value="Inventory" />
	<input type="hidden" name="alertRealId" value="<?= @$alert['id'] ?>" />

	<div class="form-group">
		<label>Status *</label>
		<select name="alertStatus" class="form-control">
			<option value="1">On</option>
			<option value="0" <?if (@$alert['alertStatus'] == 0) echo 'selected'; ?>>Off</option>
		</select>
	</div>

	<div class="form-group">
		<label>Quantity Re-order Point *</label>
		<input type="text" name="reoderQtyPoint" required="" value="<?= @$alert['reOrderQty'] ?>" class="form-control">
	</div>

	<div class="form-group">
		<label>Select Product *</label>
		<input type="text" name="selectProductInventory" id="selectProductInventory" value="" class="form-control" placeholder="Search and Select">
		<div id="selectedProductInventoryList" style="margin-top: 10px; padding: 5px;"></div>
	</div>

	<div class="form-group">
		<input type="hidden" style="opacity: 0; height: 0; width: 0;" required="" name="productListInventory" id="productListInventory" />
	</div>

	<div class="form-group">
		<label>Product Expiration Alert</label>
		<select name="productExpirationAlert" class="form-control">
			<option value="On" <?if (empty($alert)) { ?> selected <? } ?>>On</option>
			<option value="Off" <?if (@$alert['productExpirationAlert'] == 'Off') echo 'selected'; ?>>Off</option>
		</select>
	</div>

	<div class="form-group">
		<label>Enter Number of Days Before Product Expires</label>

		<div class="input-group">
			<input type="text" id="auditExpirationAlertSettings" name="auditExpirationAlertSettings" value="<?= @$alert['daysBeforeProductExpires'] * 1 ?>" class="form-control">
     		<span class="input-group-btn">
        		<button class="btn btn-default" type="button" onclick="fieldNumberChange('#auditExpirationAlertSettings', '--', 0)">-</button>
        		<button class="btn btn-default" type="button" onclick="fieldNumberChange('#auditExpirationAlertSettings', '++', 0)">+</button>
      		</span>
		</div>
	</div>

	<div class="form-group">
		<label>Do not allow use of this product within number of days product expires</label>

		<div class="input-group">
			<input type="text" id="dontAllowUseDays" name="dontAllowUseDays" value="<?= @$alert['dontAllowUseDays'] * 1 ?>" class="form-control">
     		<span class="input-group-btn">
        		<button class="btn btn-default" type="button" onclick="fieldNumberChange('#dontAllowUseDays', '--', 0)">-</button>
        		<button class="btn btn-default" type="button" onclick="fieldNumberChange('#dontAllowUseDays', '++', 0)">+</button>
      		</span>
		</div>
	</div>

	<input type="button" value="Clear" class="btn btn-danger btnReset">
	<input type="submit" value="Confirm" class="btn btn-primary" name="save_success" id="save_success">
	<input type="submit" value="Confirm & Add Another" class="btn btn-success" name="save_new" id="save_new">
</form>

<script>
	changeForms($("#alertType").val());

	function switchQuantityFields()
	{
		if ($("#quantityLimit").prop("checked"))
		{
			$("#lessThen").removeAttr("disabled");
			$("#greaterThen").removeAttr("disabled");
		} else {
			$("#lessThen").attr('disabled','disabled');
			$("#greaterThen").attr('disabled','disabled');
		}
	}

	function valNumber(field)
	{
		var v = $(field).val() * 1;

		if (isNaN(v)) $(field).val("0");
		else $(field).val(v);
	}

	function checkProductListOnFull()
	{
		if (SELECTED_ITEMS.length <= 0) {
			/*$("#audit_form input[name=save_success]").attr('disabled', 'disabled');
			$("#audit_form input[name=save_new]").attr('disabled', 'disabled');
			$("#inventory_from input[name=save_success]").attr('disabled', 'disabled');
			$("#inventory_from input[name=save_new]").attr('disabled', 'disabled');*/
		} else {
			$("#audit_form input[name=save_success]").removeAttr('disabled');
			$("#audit_form input[name=save_new]").removeAttr('disabled');
			$("#inventory_from input[name=save_success]").removeAttr('disabled');
			$("#inventory_from input[name=save_new]").removeAttr('disabled');
		}
	}

	function applyValidator()
	{
		$("#inventory_from").bootstrapValidator({
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			fields: {
				reoderQtyPoint: {
					message: 'reoderQtyPoint is not valid',
					validators: {
						notEmpty: {
							message: 'reoderQtyPoint is required and cannot be empty'
						},
						regexp: {
							regexp: /^[0-9]+$/,
							message: 'reoderQtyPoint can only consist of numerical characters'
						}
					}
				},
				productListInventory: {
					message: 'productListInventory is not valid',
					validators: {
						notEmpty: {
							message: 'productListInventory is required and cannot be empty'
						}
					}
				}
			}
		});

		$("#audit_form").bootstrapValidator({
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			fields: {
				fields: {
					auditFrequency: {
						message: 'auditFrequency is not valid',
						validators: {
							notEmpty: {
								message: 'auditFrequency is required and cannot be empty'
							},
							regexp: {
								regexp: /^[0-9]+$/,
								message: 'auditFrequency can only consist of numerical characters'
							}
						}
					},
					auditTime: {
						message: 'auditTime is not valid',
						validators: {
							notEmpty: {
								message: 'auditTime is required and cannot be empty'
							}
						}
					},
					auditStartDate: {
						message: 'auditStartDate is not valid',
						validators: {
							notEmpty: {
								message: 'auditStartDate is required and cannot be empty'
							}
						}
					},
					productListInventoryAudit: {
						message: 'productListInventoryAudit is not valid',
						validators: {
							notEmpty: {
								message: 'productListInventoryAudit is required and cannot be empty'
							}
						}
					}
				}
			}
		});
	}

	$(".btnReset").click(function() {
		$('form').find("input[type=text], textarea, select").val("");
		SELECTED_ITEMS = [];
		refreshSelectedItems();
	});

	$('.dateTimeField').datetimepicker({
		pickDate: true,
		pickTime: false,
		format: 'MM/DD/YYYY'
	});

	function fieldNumberChange(field, op, tmin, tmax)
	{
		var val = $(field).val() * 1;

		if (op == "++") val++;
		if (op == "--") val--;

		if (val < tmin) val = tmin;
		if (val > tmax) val = tmax;

		$(field).val(val);
	}

	function changeForms(value)
	{
		if (value == "Audit") {
			$("#audit_form").css("display", "block");
			$("#inventory_from").css("display", "none");
		}

		if (value == "Inventory") {
			$("#audit_form").css("display", "none");
			$("#inventory_from").css("display", "block");
		}

		SELECTED_ITEMS = [];
		refreshSelectedItems();
	}

	var SELECTED_ITEMS = [];
	var DRUGS = <?= json_encode(@$drugs_list) ?>;

	<?if (@$alert["drugList"] != "") { ?>
	loadDrugs();
	<? } ?>

	applyValidator();
	checkProductListOnFull();

	function loadDrugs()
	{
		$.ajax({
			url: "/drug/getJSON/",
			dataType: "json",
			data: {
				ids: "<?= @$alert["drugList"] ?>",
				r: Math.random()
			},
			success: function(data) {

				for (var i = 0; i < data.length; i++) {
					var id = data[i].split(" - ");
					var real_id = DRUGS[id[0]]["d_id"];
					var real_ndc = DRUGS[id[0]]["d_code"];

					SELECTED_ITEMS.push([real_id, id[1], real_ndc]);
				}

				refreshSelectedItems();
			}
		});
	}

	function removeItem(id)
	{
		for (var i = 0; i < SELECTED_ITEMS.length; i++) {
			if (SELECTED_ITEMS[i][0] == id) {
				SELECTED_ITEMS.splice(i, 1);
				i = 0;
			}
		}

		refreshSelectedItems();
	}

	function refreshSelectedItems()
	{
		$("#selectedProductList").html("");
		$("#selectedProductInventoryList").html("");

		/*var pattern = '<div class="btn-group" style="margin: 5px;">' +
			'<button type="button" class="btn btn-success">%NAME%</button>' +
			'<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">' +
			'<span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button>' +
			'<ul class="dropdown-menu" role="menu"> <li><a onclick="removeItem(%ID%);" href="javascript://void();">Remove</a></li> </ul></div> ';*/

		var pattern = '<div class="btn-group" style="margin: 5px;">' +
			'<button type="button" class="btn btn-success">%NAME% - %NDC%</button>' +
			'<button type="button" class="btn btn-success" onclick="removeItem(%ID%);" style="width: 20px;">X</button></div>';

		var ids = [];

		for (var i = 0; i < SELECTED_ITEMS.length; i++)
		{
			ids.push(SELECTED_ITEMS[i][0]);
			$("#selectedProductList").append(pattern.replace("%ID%", SELECTED_ITEMS[i][0]).replace("%NAME%", SELECTED_ITEMS[i][1]).replace("%NDC%", SELECTED_ITEMS[i][2]));
			$("#selectedProductInventoryList").append(pattern.replace("%ID%", SELECTED_ITEMS[i][0]).replace("%NAME%", SELECTED_ITEMS[i][1]).replace("%NDC%", SELECTED_ITEMS[i][2]));
		}

		$("#productListInventory").val(ids.join(","));
		$("#productListInventoryAudit").val(ids.join(","));

		checkProductListOnFull();

		/*$('#audit_form').bootstrapValidator('revalidateField', 'productListInventoryAudit');
		$('#inventory_from').bootstrapValidator('revalidateField', 'productListInventory');*/
	}

	initSearchDrugs("selectProduct");
	initSearchDrugs("selectProductInventory");

	function initSearchDrugs(field)
	{
		$("#" + field).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: "/drug/getJSON/",
					dataType: "json",
					data: {
						q: request.term,
						type: "full"
					},
					success: function( data ) {
						response( data );
					}
				});
			},
			minLength: 2,
			select: function( event, ui ) {
				var id = ui.item.label.split(" - ");
				var real_id = DRUGS[id[0]]["d_id"];
				var real_ndc = DRUGS[id[0]]["d_code"];

				SELECTED_ITEMS.push([real_id, id[1], real_ndc]);

				refreshSelectedItems();
				setTimeout(function() {
					$("#" + field).val("");
					$('#audit_form').bootstrapValidator('revalidateField', 'productListInventoryAudit');
					$('#inventory_from').bootstrapValidator('revalidateField', 'productListInventory');
				}, 100);
				return;
			},
			open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}
		});
	}
</script>