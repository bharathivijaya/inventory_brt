<h2><?if (empty($banner)){?>New Banner<?} else {echo 'Edit '.@$banner['b_name'];}?></h2>

<div class="row">

    <div class="col-md-6">
        <form action="" method="post" class="middle" id="adForm" enctype="multipart/form-data">


            <div class="form-group">
                <label>Name</label>
                <input type="text" name="b_name" value="<?=@$banner['b_name']?>" class="form-control">
            </div>

            <div class="form-group">
                <label>Layout</label>
                <select name="b_layout"  class="form-control">
                    <option value="large" <?if (@$banner['b_layout'] == 'large') {?> selected<?}?>>Large Leaderboard</option>
                    <option value="half" <?if (@$banner['b_layout'] == 'half') {?> selected<?}?>>Half Page Banner</option>
                    <option value="popup" <?if (@$banner['b_layout'] == 'popup') {?> selected<?}?>>Pop-up</option>
                </select>
            </div>

            <div class="form-group">
                <label>Location</label>
                <div class="radio">
                    <input type="radio" name="b_location" value="login" checked >Page after login
                </div>
            </div>

            <div class="form-group">
                <label>Upload Image</label>
                <input type="file" name="file" class="form-control" >
            </div>

            <div class="form-group">
                <label>Status</label>
                <div class="radio">
                    <input type="radio" name="b_status" value="Active" <?if ((@$banner['b_status'] == 'Active') || (empty($banner))){?>checked <?}?>>Active
                </div>
                <div class="radio">
                    <input type="radio" name="b_status" value="Inactive" <?if (@$banner['b_status'] == 'Inactive'){?>checked <?}?>>Inactive
                </div>
            </div>

            <input type="submit" class="btn btn-primary" value="Save">
            <button type="button" class="btn btn-danger" onclick="window.location = '<?=base_url()?>admin/banners'">Cancel</button>
        </form>
    </div>
    <div class="col-md-6">
        <?if (!empty($banner)){?>
            <img src="<?=base_url()?>../images/banners/<?=$banner['b_image']?>" alt="">
        <?}?>
    </div>
</div>






<script>/*
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
                }
            }
        });
    });*/
</script>
