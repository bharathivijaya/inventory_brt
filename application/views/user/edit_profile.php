<?php
/**
 * Created by PhpStorm.
 * User: Tan4ik
 * Date: 24.03.15
 * Time: 15:49
 */
?>
<h2>Edit Info</h2>

<form action="" method="post" class="middle" id="editprofile">
    <input type="hidden" value="<?=$user['id']?>" id="id">
    <div class="form-group">
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
        <!--<input type="text" name="cstate" value="<?=$user['cstate']?>"  class="form-control">-->
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
        <input type="text" name="ctel" value="<?=$user['ctel']?>"  class="form-control" data-mask="(999) -999-9999">
    </div>
    <div class="form-group">
        <label>Company Fax</label>
        <input type="text" name="cfax" value="<?=$user['cfax']?>"  class="form-control" data-mask="(999) -999-9999">
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" value="<?=$user['first_name']?>" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" value="<?=$user['last_name']?>" class="form-control">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label>Contact Number</label>
        <input type="text" name="contact_number" value="<?=$user['contact_number']?>" class="form-control">
    </div>
    <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" value="<?=$user['username']?>" class="form-control" disabled>
    </div>
    <div class="form-group">
        <label>NPI</label>
        <input type="text" name="npi" value="<?=$user['npi']?>" class="form-control" disabled>
    </div>
    <div class="form-group">
        <input type="submit" value="Save" class="btn btn-primary">
    </div>
    <button type="button" class="btn btn-danger" onclick="window.location = '<?=base_url()?>user/profile'">Cancel</button>
</form>

<script>
    $(document).ready(function() {
        $('#editprofile').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                czip: {
                    message: 'Zipcode is not valid',
                    validators: {
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



