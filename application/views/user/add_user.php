<?php
/**
 * Created by PhpStorm.
 * User: Tan4ik
 * Date: 24.03.15
 * Time: 20:56
 */ ?>
<h2><?if(empty($user)){print('New');}else{print('Edit');} print(' user')?></h2>
<form action="" method="post" class="narrow" id="userform">
    <div class="form-group">
        <label>First Name</label>
        <input type="text" name="first_name" <?if (!empty($user)){?>value="<?=$user['first_name']?>"<?}?> placeholder="First Name" class="form-control">
    </div>
    <div class="form-group">
        <label>Last Name</label>
        <input type="text" name="last_name" <?if (!empty($user)){?>value="<?=$user['last_name']?>"<?}?> placeholder="Last Name" class="form-control">
    </div>
    <div class="form-group">
        <label>Role</label>
        <select name="role" class="form-control">
            <option value="Pharmacist" <?if (@$user['role'] == 'Pharmacist'){echo 'selected';}?>>Pharmacist</option>
            <option value="Pharmacy Tech" <?if (@$user['role'] == 'Pharmacy Tech'){echo 'selected';}?>>Pharmacy Tech</option>
            <option value="Other" <?if (@$user['role'] == 'Other'){echo 'selected';}?>>Other</option>
        </select>
    </div>
    <div class="form-group">
        <label>License Number</label>
        <input type="text" name="license_number" <?if (!empty($user)){?>value="<?=$user['license_number']?>"<?}?> placeholder="License Number"  class="form-control">
    </div>

    <div class="form-group">
        <label>License Expiry</label>
        <input type="text" name="license_expiry" id="date" data-datestart="<?=date('m/d/Y', strtotime('tomorrow'))?>" class="form-control  datetimeST "  value="<? if(@$user['license_expiry']) echo @date('m/d/Y', $user['license_expiry']); else echo @date('m/d/Y', strtotime('tomorrow'));?>"  tabindex="6">
    </div>

    <?if (empty($user)){?>
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Username"  class="form-control">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email"  placeholder="Email"  class="form-control">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Password"  class="form-control">
        </div>
        <div class="form-group">
            <label>Repeat Password</label>
            <input type="password" name="password2" placeholder="Repeat Password"  class="form-control">
        </div>
    <?}?>

    <div class="form-group">
    <label>Reports</label>
        <select name="reports" class="form-control">
            <option value="On" <?if (@$user['reports'] == 'On'){echo 'selected';}?>>On</option>
            <option value="Off" <?if (@$user['reports'] == 'Off'){echo 'selected';}?>>Off</option>
        </select>
    </div>

	<div class="form-group">
		<label>Alerts</label>
		<select name="alerts" class="form-control">
			<option value="On" <?if (@$user['alerts'] == 'On'){echo 'selected';}?>>On</option>
			<option value="Off" <?if (@$user['alerts'] == 'Off'){echo 'selected';}?>>Off</option>
		</select>
	</div>

    <div class="form-group">
        <input type="submit" value="Save" class="btn btn-success">
    </div>
    <button class="btn btn-danger" onclick="window.location = '<?=base_url()?>user/my_users'">Cancel</button>
</form>

<script>
    $(document).ready(function() {
        //$.noConflict();
        // console.log($('#loginform').html());
        $('#userform').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {

                username: {
                    message: 'The username is not valid',
                    validators: {
                        remote: {
                            url: '<?=base_url()?>user/checkUsername/'+$('#username').val(),
                            data: function(validator) {
                                return {
                                    username: validator.getFieldElements('username').val()
                                };
                            },
                            message: 'The username is not available'
                        },
                        notEmpty: {
                            message: 'The username is required and cannot be empty'
                        },
                        stringLength: {
                            min: 3,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9]+$/,
                            message: 'The username can only consist of alphabetical and number'
                        },
                        different: {
                            field: 'password',
                            message: 'The username and password cannot be the same as each other'
                        }
                    }
                },

                email: {
                    validators: {
                        remote: {
                            url: '<?=base_url()?>user/checkEmail/'+encodeURIComponent($('#email').val()),
                            data: function(validator) {
                                return {
                                    email: validator.getFieldElements('email').val()
                                };
                            },
                            message: 'The email is not available'
                        },
                        /*notEmpty: {
                            message: 'The email address is required and cannot be empty'
                        },*/
                        emailAddress: {
                            message: 'The email address is not a valid'
                        }
                    }
                },

                password: {
                    validators: {
                        notEmpty: {
                            message: 'The password is required and cannot be empty'
                        },
                        different: {
                            field: 'username',
                            message: 'The password cannot be the same as username'
                        },
                        stringLength: {
                            min: 8,
                            message: 'The password must have at least 8 characters'
                        },
                        identical: {
                            field: 'password2',
                            message: 'The password and its confirm are not the same'
                        }
                    }
                },
                password2: {
                    validators: {
                        notEmpty: {
                            message: 'The password is required and cannot be empty'
                        },
                        identical: {
                            field: 'password',
                            message: 'The password and its confirm are not the same'
                        }
                    }
                }
            }
        });

    });

    $('.datetimeST').datetimepicker({
        pickDate: true,
        pickTime: false,
        format: 'MM/DD/YYYY',
        minDate: '<?=date('m/d/Y', strtotime('tomorrow'))?>'
    });
</script>
