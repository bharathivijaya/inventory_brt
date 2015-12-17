<?php 
if (count($drug_data)) {
?>

<h2><?php echo $drug_data['0']->d_name;?></h2>
<a href="<?php echo base_url()?>drug/view_drug/<?php echo $drug_data['0']->d_id?>">Product Info</a> | <a href="<?php echo base_url()?>drug/inventory_in/<?php echo $drug_data['0']->d_id?>">Inventory In</a> | <a href="<?php echo base_url()?>drug/inventory_out/<?php echo $drug_data['0']->d_id?>">Inventory Out</a> | <a href="<?php echo base_url()?>drug/inventory_audit/<?php echo $drug_data['0']->d_id?>">Inventory Audit</a> |
<?//if ($drug["d_lotTracking"]) { ?>
<a href="<?php echo base_url()?>drug/lots/<?php echo $drug_data['0']->d_id?>">Inventory Lot Tracking</a> |
<?// } ?>
<a href="<?php echo base_url()?>drug/alerts/<?php echo $drug_data['0']->d_id?>">Alert History</a> | <b>View Alert</b> | <a href="<?php echo base_url()?>category/add_drug_category/<?php echo  $drug_data['0']->d_id ?>">Add Category</a> <br/>
<?php 
if (count($alert_data)) {
	
?>
<table width="782" border="0" class="alert_table">
  <tr >
    <td  width="350">&nbsp;</td>
    <td align="right"><strong><a href="<?php echo base_url()?>alert/edit/<?php echo $alert_data['0']->id;?>" class="btn btn-primary">Edit Alert </a></strong></td>
  </tr>
  <tr class="alert_view_row_border">
    <td class="dashboard-headings"><strong>Alert type</strong></td>
    <td align="left" class="alert_row_gray"><?php echo $alert_data['0']->alertType;?></td>
  </tr>
  <?php 
if ($alert_data['0']->alertType == 'Audit') {
	?>
  <tr class="alert_view_row_border">
    <td class="dashboard-headings"><strong>Audit Frequency</strong></td>
    <td class="alert_row_gray"><?php echo $alert_data['0']->auditFrequency;?></td>
  </tr>
  <tr class="alert_view_row_border">
    <td class="dashboard-headings"><strong>Status</strong></td>
    <td class="alert_row_gray"><?php echo ($alert_data['0']->alertStatus == '1'? 'On': 'Off' );?></td>
  </tr>
  <tr class="alert_view_row_border">
    <td class="dashboard-headings"><strong>Audit Time</strong></td>
    <td class="alert_row_gray"><?php echo $alert_data['0']->auditTime;?></td>
  </tr>
  <tr class="alert_view_row_border">
    <td class="dashboard-headings"><strong>Audit Start Date</strong></td>
    <td class="alert_row_gray"><?php echo ($alert_data['0']->auditStartDate != '0'? date("m/d/Y", $alert_data['0']->auditStartDate) : '');?></td>
  </tr>
  <tr class="alert_view_row_border">
    <td class="dashboard-headings"><strong>Audit End Date</strong></td>
    <td class="alert_row_gray"><?php echo ($alert_data['0']->auditEndDate != '0'? date("m/d/Y", $alert_data['0']->auditEndDate) : '');?></td>
  </tr>
  <tr >
    <td class="dashboard-headings"><strong>Alert Triggers</strong></td>
    <td class="alert_row_gray"></td>
  </tr>
  <tr >
    <td class="dashboard-headings"><strong> &nbsp;- Negative Inventory</strong></td>
    <td class="alert_row_gray"><?php echo ($alert_data['0']->negativeInventory == 'On'? 'Yes': 'No' );?></td>
  </tr>
  <tr class="alert_view_row_border">
    <td class="dashboard-headings"><strong> &nbsp;- Quantity Limit</strong></td>
    <td class="alert_row_gray"><?php echo ($alert_data['0']->quantityLimit == 'On'? 'Yes': 'No' );?></td>
  </tr>
  <?php 
  if ($alert_data['0']->quantityLimit == 'On') {
  	?>
  <tr>
    <td class="dashboard-headings" style="padding-left:40px;"><strong>&#8226; Quantity - Less Than or Equal To</strong></td>
    <td class="alert_row_gray"><?php echo $alert_data['0']->lessThan;?></td>
  </tr>
  <tr class="alert_view_row_border">
    <td class="dashboard-headings" style="padding-left:40px;"><strong>&#8226; Quantity - Greater Than or Equal To</strong></td>
    <td class="alert_row_gray"><?php echo $alert_data['0']->greaterThan;?></td>
  </tr>
  <?php
  }
  ?>
  <tr class="alert_view_row_border">
    <td class="dashboard-headings"><strong>Force Audit</strong></td>
    <td class="alert_row_gray"><?php echo $alert_data['0']->forceAudit;?></td>
  </tr>
  <tr class="alert_view_row_border">
    <td class="dashboard-headings"><strong>Reschedule Audit After Last Audit</strong></td>
    <td class="alert_row_gray"><?php echo $alert_data['0']->rescheduleAuditAfterLastAudit;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php
}elseif ($alert_data['0']->alertType == 'Inventory'){
	?>
  <tr class="alert_view_row_border">
    <td class="dashboard-headings">&nbsp;</td>
    <td class="alert_row_gray">&nbsp;</td>
  </tr>
  <tr class="alert_view_row_border">
    <td class="dashboard-headings"><strong>Status</strong></td>
    <td class="alert_row_gray"><?php echo ($alert_data['0']->alertStatus == '1'? 'On': 'Off' );?></td>
  </tr>
  <tr class="alert_view_row_border">
    <td class="dashboard-headings">&nbsp;</td>
    <td class="alert_row_gray">&nbsp;</td>
  </tr>
  <tr class="alert_view_row_border">
    <td class="dashboard-headings"><strong>Quantity Re-order Point</strong></td>
    <td class="alert_row_gray"><?php echo $alert_data['0']->reOrderQty;?></td>
  </tr>
  <tr class="alert_view_row_border">
    <td class="dashboard-headings">&nbsp;</td>
    <td class="alert_row_gray">&nbsp;</td>
  </tr>
  <tr class="alert_view_row_border">
    <td class="dashboard-headings"><strong>Product Expiration Alert</strong></td>
    <td class="alert_row_gray"><?php echo $alert_data['0']->productExpirationAlert;?></td>
  </tr>
  <tr class="alert_view_row_border">
    <td class="dashboard-headings"><strong>Number of Days Before Product Expires</strong></td>
    <td class="alert_row_gray"><?php echo $alert_data['0']->daysBeforeProductExpires;?></td>
  </tr>
  <tr class="alert_view_row_border">
    <td class="dashboard-headings"><strong>Do not allow use of this product within number of days product expires</strong></td>
    <td class="alert_row_gray"><?php echo $alert_data['0']->dontAllowUseDays;?></td>
  </tr>
  <?php
}
?>
</table>
<?php } else 
{
	echo "Alert details not found";
} ?>
<?php
	
}else
{
	echo "Drug details not found";
}
?>
