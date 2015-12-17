<h2><?if (empty($vendor)){echo 'New';} else {echo 'Edit';}?> Vendor</h2>

<form action="" method="post" class="narrow" id="vendorform">
    <div class="form-group">
        <label>Name</label>
        <input type="text" name="v_name" value="<?=@$vendor['v_name']?>" class="form-control uppercase" required>
    </div>
    <div class="form-group">
        <label>Address</label>
        <input type="text" name="v_address" value="<?=@$vendor['v_address']?>" class="form-control uppercase">
    </div>
    <div class="form-group">
        <label>City</label>
        <input type="text" name="v_city" value="<?=@$vendor['v_city']?>"  class="form-control uppercase">
    </div>
    <div class="form-group">
        <label>State</label>
        <select name="v_state"  class="form-control">
            <option value="" <?if (empty($vendor)){echo 'selected';}?>>Select State</option>
            <option value="Alabama" <?if (@$vendor['v_state'] == 'Alabama'){echo 'selected';}?>>Alabama</option>
            <option value="Alaska" <?if (@$vendor['v_state'] == 'Alaska'){echo 'selected';}?>>Alaska</option>
            <option value="Arizona" <?if (@$vendor['v_state'] == 'Arizona'){echo 'selected';}?>>Arizona</option>
            <option value="Arkansas" <?if (@$vendor['v_state'] == 'Arkansas'){echo 'selected';}?>>Arkansas</option>
            <option value="California" <?if (@$vendor['v_state'] == 'California'){echo 'selected';}?>>California</option>
            <option value="Colorado" <?if (@$vendor['v_state'] == 'Colorado'){echo 'selected';}?>>Colorado</option>
            <option value="Connecticut" <?if (@$vendor['v_state'] == 'Connecticut'){echo 'selected';}?>>Connecticut</option>
            <option value="Delaware" <?if (@$vendor['v_state'] == 'Delaware'){echo 'selected';}?>>Delaware</option>
            <option value="District Of Columbia" <?if (@$vendor['vstate'] == 'District Of Columbia'){echo 'selected';}?>>District Of Columbia</option>
            <option value="Florida" <?if (@$vendor['v_state'] == 'Florida'){echo 'selected';}?>>Florida</option>
            <option value="Georgia" <?if (@$vendor['v_state'] == 'Georgia'){echo 'selected';}?>>Georgia</option>
            <option value="Hawaii" <?if (@$vendor['v_state'] == 'Hawaii'){echo 'selected';}?>>Hawaii</option>
            <option value="Idaho" <?if (@$vendor['v_state'] == 'Idaho'){echo 'selected';}?>>Idaho</option>
            <option value="Illinois" <?if (@$vendor['v_state'] == 'Illinois'){echo 'selected';}?>>Illinois</option>
            <option value="Indiana" <?if (@$vendor['v_state'] == 'Indiana'){echo 'selected';}?>>Indiana</option>
            <option value="Iowa" <?if (@$vendor['v_state'] == 'Iowa'){echo 'selected';}?>>Iowa</option>
            <option value="Kansas" <?if (@$vendor['v_state'] == 'Kansas'){echo 'selected';}?>>Kansas</option>
            <option value="Kentucky" <?if (@$vendor['v_state'] == 'Kentucky'){echo 'selected';}?>>Kentucky</option>
            <option value="Louisiana" <?if (@$vendor['v_state'] == 'Louisiana'){echo 'selected';}?>>Louisiana</option>
            <option value="Maine" <?if (@$vendor['v_state'] == 'Maine'){echo 'selected';}?>>Maine</option>
            <option value="Maryland" <?if (@$vendor['v_state'] == 'Maryland'){echo 'selected';}?>>Maryland</option>
            <option value="Massachusetts" <?if (@$vendor['v_state'] == 'Massachusetts'){echo 'selected';}?>>Massachusetts</option>
            <option value="Michigan" <?if (@$vendor['v_state'] == 'Michigan'){echo 'selected';}?>>Michigan</option>
            <option value="Minnesota" <?if (@$vendor['v_state'] == 'Minnesota'){echo 'selected';}?>>Minnesota</option>
            <option value="Mississippi" <?if (@$vendor['v_state'] == 'Mississippi'){echo 'selected';}?>>Mississippi</option>
            <option value="Missouri" <?if (@$vendor['v_state'] == 'Missouri'){echo 'selected';}?>>Missouri</option>
            <option value="Montana" <?if (@$vendor['v_state'] == 'Montana'){echo 'selected';}?>>Montana</option>
            <option value="Nebraska" <?if (@$vendor['v_state'] == 'Nebraska'){echo 'selected';}?>>Nebraska</option>
            <option value="Nevada" <?if (@$vendor['v_state'] == 'Nevada'){echo 'selected';}?>>Nevada</option>
            <option value="New Hampshire" <?if (@$vendor['v_state'] == 'New Hampshire'){echo 'selected';}?>>New Hampshire</option>
            <option value="New Jersey" <?if (@$vendor['v_state'] == 'New Jersey'){echo 'selected';}?>>New Jersey</option>
            <option value="New Mexico" <?if (@$vendor['v_state'] == 'New Mexico'){echo 'selected';}?>>New Mexico</option>
            <option value="New York" <?if (@$vendor['v_state'] == 'New York'){echo 'selected';}?>>New York</option>
            <option value="North Carolina" <?if (@$vendor['v_state'] == 'North Carolina'){echo 'selected';}?>>North Carolina</option>
            <option value="North Dakota" <?if (@$vendor['v_state'] == 'North Dakota'){echo 'selected';}?>>North Dakota</option>
            <option value="Ohio" <?if (@$vendor['v_state'] == 'Ohio'){echo 'selected';}?>>Ohio</option>
            <option value="Oklahoma" <?if (@$vendor['v_state'] == 'Oklahoma'){echo 'selected';}?>>Oklahoma</option>
            <option value="Oregon" <?if (@$vendor['v_state'] == 'Oregon'){echo 'selected';}?>>Oregon</option>
            <option value="Pennsylvania" <?if (@$vendor['v_state'] == 'Pennsylvania'){echo 'selected';}?>>Pennsylvania</option>
            <option value="Rhode Island" <?if (@$vendor['v_state'] == 'Rhode Island'){echo 'selected';}?>>Rhode Island</option>
            <option value="South Carolina" <?if (@$vendor['v_state'] == 'South Carolina'){echo 'selected';}?>>South Carolina</option>
            <option value="South Dakota" <?if (@$vendor['v_state'] == 'South Dakota'){echo 'selected';}?>>South Dakota</option>
            <option value="Tennessee" <?if (@$vendor['v_state'] == 'Tennessee'){echo 'selected';}?>>Tennessee</option>
            <option value="Texas" <?if (@$vendor['v_state'] == 'Texas'){echo 'selected';}?>>Texas</option>
            <option value="Utah" <?if (@$vendor['v_state'] == 'Utah'){echo 'selected';}?>>Utah</option>
            <option value="Vermont" <?if (@$vendor['v_state'] == 'Vermont'){echo 'selected';}?>>Vermont</option>
            <option value="Virginia" <?if (@$vendor['v_state'] == 'Virginia'){echo 'selected';}?>>Virginia</option>
            <option value="Washington" <?if (@$vendor['v_state'] == 'Washington'){echo 'selected';}?>>Washington</option>
            <option value="West Virginia" <?if (@$vendor['v_state'] == 'West Virginia'){echo 'selected';}?>>West Virginia</option>
            <option value="Wisconsin" <?if (@$vendor['v_state'] == 'Wisconsin'){echo 'selected';}?>>Wisconsin</option>
            <option value="Wyoming" <?if (@$vendor['v_state'] == 'Wyoming'){echo 'selected';}?>>Wyoming</option>
        </select>

    </div>
    <div class="form-group">
        <label>Zipcode</label>
        <input type="text" name="v_zip" value="<?=@$vendor['v_zip']?>"  class="form-control">
    </div>
    <div class="form-group">
        <label>Tel</label>
        <input type="text" name="v_tel" value="<?=@$vendor['v_tel']?>" class="form-control" data-mask="(999) -999-9999">
    </div>
    <div class="form-group">
        <label>Fax</label>
        <input type="text" name="v_fax" value="<?=@$vendor['v_fax']?>"  class="form-control" data-mask="(999) -999-9999">
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="v_email" value="<?=@$vendor['v_email']?>"  class="form-control uppercase">
    </div>
    <div class="form-group">
        <label>License</label>
        <input type="text" name="v_license" value="<?=@$vendor['v_license']?>"  class="form-control uppercase">
    </div>
    <div class="form-group">
        <label>DEA</label>
        <input type="text" name="v_dea" value="<?=@$vendor['v_dea']?>"  class="form-control uppercase" id="dea">
    </div>
    <div class="form-group">
        <label>Contact Name</label>
        <input type="text" name="v_cname" value="<?=@$vendor['v_cname']?>"  class="form-control uppercase">
    </div>
    <div class="form-group">
        <label>Status</label>
        <select name="v_status" class="form-control">
            <option value="Active" <?if(@$vendor['v_status'] == 'Active'){echo 'selected';}?>>Active</option>
            <option value="Inactive" <?if(@$vendor['v_status'] == 'Inactive'){echo 'selected';}?>>Inactive</option>
        </select>
    </div>

    <input type="submit" value="Save" class="btn btn-primary">
</form>

<script>
    $(document).ready(function() {
        $('#vendorform').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                v_dea: {
                    message: 'DEA is not valid',
                    validators: {
                        remote: {
                            url: '<?=base_url()?>vendor/checkDea/'+$('#dea').val(),
                            data: function(validator) {
                                return {
                                    v_dea: validator.getFieldElements('v_dea').val()
                                };
                            },
                            message: 'DEA is not available'
                        },/*
                        notEmpty: {
                            message: 'DEA is required and cannot be empty'
                        },*/
                        stringLength: {
                            min: 9,
                            max: 9,
                            message: 'DEA must be 9 characters long'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9]+$/,
                            message: 'NPI can only consist of numerical and alphabetical characters'
                        }
                    }
                },
                v_zip: {
                    message: 'Zipcode is not valid',
                    validators: {
                        /*notEmpty: {
                            message: 'DEA is required and cannot be empty'
                        },
                        stringLength: {
                            min: 9,
                            max: 9,
                            message: 'DEA must be 9 characters long'
                        },*/
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'Zipcode can only consist of numerical characters'
                        }
                    }
                }

            }
        });
    });
</script>