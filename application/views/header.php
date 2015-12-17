<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Narcotic eLogBook</title>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?=base_url()?>bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/style.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/jquery-ui.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.5/css/jquery.dataTables.min.css">
<!--table-sort-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/css/bootstrapvalidator.min.css" rel="stylesheet">
<link href="<?=base_url()?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/js/moment.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<!--table-sort-->
<script src="//cdn.datatables.net/plug-ins/1.10.7/filtering/type-based/html.js"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.7/filtering/type-based/accent-neutralise.js"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.7/filtering/type-based/phoneNumber.js"></script>
<script src="<?=base_url()?>assets/js/jasny-bootstrap.min.js"></script>
<!--for mask input-->
<script type="text/javascript" src="<?=base_url()?>assets/js/editor/tinymce.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery-ui.min.js"></script>
</head>
<body>
<div class="wrapper">
<div class="header">
  <div class="container">
    <div class="row">
      <div class="col-md-3" style="padding:10px"> <a href="<?=base_url()?>logbook/dashboard"><img src="<?=base_url()?>images/logo.jpg" height="50px" alt=""> </a> <span class="tiny">Pharmacy Made Perfect</span> </div>
      <div class="col-md-4"> <a href="<?=base_url()?>logbook/dashboard" class="productSpBtn" style="  border-radius: 10px 0px 0px 10px;">Home</a> <a href="<?=base_url()?>main/about" class="productSpBtn"  >About Us</a> <a  href="<?=base_url()?>main/contact" class="productSpBtn">Contact us</a> <a href="<?=base_url()?>phpfaq/index.php" class="productSpBtn">FAQ</a> <a href="<?=base_url()?>main/policies" class="productSpBtn" style="  border-radius: 0px 10px 10px 0px;">Policies</a>
        <div class="clearfix"></div>
      </div>
      <div class="col-md-5">
        <div class="row mtop10">
          <? if(!$loggedIn) { ?>
          <form action="<?=base_url()?>user/login" method="post">
            <div class="row">
              <div class="col-md-4">
                <input type="text" name="username" placeholder="Enter Username" class="smallFont form-control" tabindex="1" required>
                <a href="<?=base_url()?>user/forgot_username">Forgot Username?</a> </div>
              <div class="col-md-4">
                <input type="password" name="password" placeholder="Enter Password" class="smallFont form-control" tabindex="2" required>
                <a href="<?=base_url()?>user/forgot_password">Forgot Password?</a> </div>
              <div class="col-md-4">
                <input type="submit" value="Log in" class="btn smallFont bluebutton">
                <br>
                <input type="checkbox" name="remember">
                Remember me? </div>
            </div>
          </form>
          <? }else { ?>
          <div class="row">
            <div class="col-md-10" style="text-align:right;"> <a href="<?=base_url()?>user/profile">
              <?=$this->session->userdata('username')?>
              </a> <span style="color:#428bca;padding:3px;font-size: 14px;line-height: 1.42857;">|</span> <a href="<?=base_url()?>user/logout">Log out</a>
              <? } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?if ($loggedIn) {?>
    <div class="row mymenu">
      <ul>
        <?if (($this->session->userdata('type') !== 'admin') && ($this->session->userdata('type') !== 'super')) {?>
        <li><a href="<?=base_url()?>logbook/dashboard">Dashboard</a> </li>
        <!--<li><a href="<?/*=base_url()*/?>user/profile">My Account</a> </li>-->
        <li><a id="logbook_hover" href="<?=base_url()?>logbook/index">LogBook</a></li>
        <ul id="logbook_menu" class="ul-menu" style="margin-left: 120px;">
          <li><a id="logbook_new_entry" href="<?=base_url()?>logbook/index">New Entry</a></li>
          <ul id="logbook_menu_2" class="ul-menu" style="margin-left: 132px; margin-top: -41px; width: 200px;">
            <li><a href="<?=base_url()?>logbook/add_entry_in">Inventory In</a></li>
            <li><a href="<?=base_url()?>logbook/add_entry_out">Inventory Out</a></li>
            <li><a href="<?=base_url()?>logbook/add_entry_audit">Inventory Audit</a></li>
          </ul>
          <li><a href="<?=base_url()?>drug/">My Drugs</a></li>
          <li><a href="<?=base_url()?>vendor/">My Vendors</a></li>
          <li><a href="<?=base_url()?>category/">My Categories</a></li>
          <li><a href="<?=base_url()?>alert/">Alert Manager</a></li>
          <li><a href="<?=base_url()?>edit_transaction/">Transactions</a></li>
        </ul>
        <li><a href="<?=base_url()?>report/index">Reports</a></li>
        <?} else {?>
        <!--<li><a href="<?=base_url()?>admin/">Home</a></li>-->
        <li><a href="<?=base_url()?>user/profile">My Account</a> </li>
        <li><a href="<?=base_url()?>admin/customers">Manage Users</a></li>
        <?if ($this->session->userdata('type') == 'super') {?>
        <li><a href="<?=base_url()?>admin/admins">Admins</a></li>
        <?}?>
        <li><a href="<?=base_url()?>admin/master_file">Master File</a></li>
        <li><a href="<?=base_url()?>admin/statistic">Site Statistics</a></li>
        <li><a href="<?=base_url()?>admin/cms">CMS</a></li>
        <li><a href="<?=base_url()?>admin/reports">Reports</a></li>
        <li><a href="<?=base_url()?>admin/banners">Advertisement</a></li>
        <?}?>
      </ul>
    </div>
    <?}?>
  </div>
</div>
<div <? if($thisView != 'main/index') echo 'class="main"' ?>>
<div class="container" <? if($thisView == 'main/index') echo 'style="padding:0px"' ?>>
<script src="<?php echo base_url();?>assets/js/logbookmenu.js"></script>
