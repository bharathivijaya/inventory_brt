<h2>Change Password</h2>
<form action="" method="post" id="newPasswordForm" class="narrow">
    <div class="form-group">
    <input type="password" name="old_password" placeholder="Current Password" required class="form-control">
     </div>
    <div class="form-group">
    <input type="password" name="password" placeholder="New Password" required class="form-control">
    </div><div class="form-group">
        <input type="password" name="password2" placeholder="Repeat Password" required class="form-control">
        </div><div class="form-group">
    <input type="submit" value="Save" class="btn btn-primary">
        </div>
</form>

<script>
    $(document).ready(function() {



        $('#newPasswordForm').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                password: {
                    validators: {
                        notEmpty: {
                            message: 'The password is required and cannot be empty'
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
</script>