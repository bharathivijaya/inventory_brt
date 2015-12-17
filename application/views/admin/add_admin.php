<h2><?if (empty($user)){?>New Admin<?} else {echo 'Edit '.@$user['username'];}?></h2>

<div class="row">
    <h3>Admin info</h3>
</div>

<form action="" method="post" class="middle" id="adForm">
    <!--<input type="hidden" value="<?=$user['id']?>" id="id">-->
    <!--<div class="form-group">
        <label>Company Name</label>
        <input type="text" name="cname" value="<?=$user['cname']?>" required class="form-control">
    </div>
    <div class="form-group">
        <label>Company Address</label>
        <input type="text" name="caddress" value="<?=$user['caddress']?>" required class="form-control">
    </div>
    <div class="form-group">
        <label>City</label>
        <input type="text" name="ccity" value="<?=$user['ccity']?>"  class="form-control">
    </div>
    <div class="form-group">
        <label>State</label>
        <select name="cstate"  class="form-control">
            <option value="Alabama" <?if ($user['cstate'] == 'Alabama'){echo 'selected';}?>>Alabama</option>
            <option value="Alaska" <?if ($user['cstate'] == 'Alaska'){echo 'selected';}?>>Alaska</option>
            <option value="Arizona" <?if ($user['cstate'] == 'Arizona'){echo 'selected';}?>>Arizona</option>
            <option value="Arkansas" <?if ($user['cstate'] == 'Arkansas'){echo 'selected';}?>>Arkansas</option>
            <option value="California" <?if ($user['cstate'] == 'California'){echo 'selected';}?>>California</option>
            <option value="Colorado" <?if ($user['cstate'] == 'Colorado'){echo 'selected';}?>>Colorado</option>
            <option value="Connecticut" <?if ($user['cstate'] == 'Connecticut'){echo 'selected';}?>>Connecticut</option>
            <option value="Delaware" <?if ($user['cstate'] == 'Delaware'){echo 'selected';}?>>Delaware</option>
            <option value="District Of Columbia" <?if ($user['cstate'] == 'District Of Columbia'){echo 'selected';}?>>District Of Columbia</option>
            <option value="Florida" <?if ($user['cstate'] == 'Florida'){echo 'selected';}?>>Florida</option>
            <option value="Georgia" <?if ($user['cstate'] == 'Georgia'){echo 'selected';}?>>Georgia</option>
            <option value="Hawaii" <?if ($user['cstate'] == 'Hawaii'){echo 'selected';}?>>Hawaii</option>
            <option value="Idaho" <?if ($user['cstate'] == 'Idaho'){echo 'selected';}?>>Idaho</option>
            <option value="Illinois" <?if ($user['cstate'] == 'Illinois'){echo 'selected';}?>>Illinois</option>
            <option value="Indiana" <?if ($user['cstate'] == 'Indiana'){echo 'selected';}?>>Indiana</option>
            <option value="Iowa" <?if ($user['cstate'] == 'Iowa'){echo 'selected';}?>>Iowa</option>
            <option value="Kansas" <?if ($user['cstate'] == 'Kansas'){echo 'selected';}?>>Kansas</option>
            <option value="Kentucky" <?if ($user['cstate'] == 'Kentucky'){echo 'selected';}?>>Kentucky</option>
            <option value="Louisiana" <?if ($user['cstate'] == 'Louisiana'){echo 'selected';}?>>Louisiana</option>
            <option value="Maine" <?if ($user['cstate'] == 'Maine'){echo 'selected';}?>>Maine</option>
            <option value="Maryland" <?if ($user['cstate'] == 'Maryland'){echo 'selected';}?>>Maryland</option>
            <option value="Massachusetts" <?if ($user['cstate'] == 'Massachusetts'){echo 'selected';}?>>Massachusetts</option>
            <option value="Michigan" <?if ($user['cstate'] == 'Michigan'){echo 'selected';}?>>Michigan</option>
            <option value="Minnesota" <?if ($user['cstate'] == 'Minnesota'){echo 'selected';}?>>Minnesota</option>
            <option value="Mississippi" <?if ($user['cstate'] == 'Mississippi'){echo 'selected';}?>>Mississippi</option>
            <option value="Missouri" <?if ($user['cstate'] == 'Missouri'){echo 'selected';}?>>Missouri</option>
            <option value="Montana" <?if ($user['cstate'] == 'Montana'){echo 'selected';}?>>Montana</option>
            <option value="Nebraska" <?if ($user['cstate'] == 'Nebraska'){echo 'selected';}?>>Nebraska</option>
            <option value="Nevada" <?if ($user['cstate'] == 'Nevada'){echo 'selected';}?>>Nevada</option>
            <option value="New Hampshire" <?if ($user['cstate'] == 'New Hampshire'){echo 'selected';}?>>New Hampshire</option>
            <option value="New Jersey" <?if ($user['cstate'] == 'New Jersey'){echo 'selected';}?>>New Jersey</option>
            <option value="New Mexico" <?if ($user['cstate'] == 'New Mexico'){echo 'selected';}?>>New Mexico</option>
            <option value="New York" <?if ($user['cstate'] == 'New York'){echo 'selected';}?>>New York</option>
            <option value="North Carolina" <?if ($user['cstate'] == 'North Carolina'){echo 'selected';}?>>North Carolina</option>
            <option value="North Dakota" <?if ($user['cstate'] == 'North Dakota'){echo 'selected';}?>>North Dakota</option>
            <option value="Ohio" <?if ($user['cstate'] == 'Ohio'){echo 'selected';}?>>Ohio</option>
            <option value="Oklahoma" <?if ($user['cstate'] == 'Oklahoma'){echo 'selected';}?>>Oklahoma</option>
            <option value="Oregon" <?if ($user['cstate'] == 'Oregon'){echo 'selected';}?>>Oregon</option>
            <option value="Pennsylvania" <?if ($user['cstate'] == 'Pennsylvania'){echo 'selected';}?>>Pennsylvania</option>
            <option value="Rhode Island" <?if ($user['cstate'] == 'Rhode Island'){echo 'selected';}?>>Rhode Island</option>
            <option value="South Carolina" <?if ($user['cstate'] == 'South Carolina'){echo 'selected';}?>>South Carolina</option>
            <option value="South Dakota" <?if ($user['cstate'] == 'South Dakota'){echo 'selected';}?>>South Dakota</option>
            <option value="Tennessee" <?if ($user['cstate'] == 'Tennessee'){echo 'selected';}?>>Tennessee</option>
            <option value="Texas" <?if ($user['cstate'] == 'Texas'){echo 'selected';}?>>Texas</option>
            <option value="Utah" <?if ($user['cstate'] == 'Utah'){echo 'selected';}?>>Utah</option>
            <option value="Vermont" <?if ($user['cstate'] == 'Vermont'){echo 'selected';}?>>Vermont</option>
            <option value="Virginia" <?if ($user['cstate'] == 'Virginia'){echo 'selected';}?>>Virginia</option>
            <option value="Washington" <?if ($user['cstate'] == 'Washington'){echo 'selected';}?>>Washington</option>
            <option value="West Virginia" <?if ($user['cstate'] == 'West Virginia'){echo 'selected';}?>>West Virginia</option>
            <option value="Wisconsin" <?if ($user['cstate'] == 'Wisconsin'){echo 'selected';}?>>Wisconsin</option>
            <option value="Wyoming" <?if ($user['cstate'] == 'Wyoming'){echo 'selected';}?>>Wyoming</option>
        </select>

    </div>
    <div class="form-group">
        <label>Zipcode</label>
        <input type="text" name="czip" value="<?=$user['czip']?>"  class="form-control">
    </div>
    <div class="form-group">
        <label>Company Tel</label>
        <input type="text" name="ctel" value="<?=$user['ctel']?>"  class="form-control"  data-mask="(999) -999-9999">
    </div>
    <div class="form-group">
        <label>Company Fax</label>
        <input type="text" name="cfax" value="<?=$user['cfax']?>"  class="form-control"  data-mask="(999) -999-9999">
    </div>-->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" value="<?=@$user['first_name']?>" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" value="<?=@$user['last_name']?>" class="form-control">
            </div>
        </div>
    </div>
    <!--<div class="form-group">
        <label>Contact Number</label>
        <input type="text" name="contact_number" value="<?=$user['contact_number']?>" class="form-control">
    </div>-->
    <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" value="<?=@$user['username']?>" class="form-control" <?if (!empty($user)) {?> disabled<?}?>>
    </div>
    <!--
    <div class="form-group">
        <label>NPI</label>
        <input type="text" name="npi" value="<?=$user['npi']?>" class="form-control" disabled>
    </div>-->

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?=@$user['email']?>" class="form-control" <?if (!empty($user)) {?> disabled<?}?>>
        </div>
    <?if (empty($user)) {?>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" value="" class="form-control" >
        </div>
        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="password2" value="" class="form-control" >
        </div>
    <?}?>
    <div class="form-group">
        <input type="submit" value="Save" class="btn btn-primary">
    </div>
    <button type="button" class="btn btn-danger" onclick="window.location = '<?=base_url()?>admin/admins'">Cancel</button>
</form>


<script>
    $(document).ready(function() {
        $('#adForm').bootstrapValidator({
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
                        notEmpty: {
                            message: 'The email address is required and cannot be empty'
                        },
                        emailAddress: {
                            message: 'The email address is not a valid'
                        }
                    }
                }

            }
        });
    });
</script>
