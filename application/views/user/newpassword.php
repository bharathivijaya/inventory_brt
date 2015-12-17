<h2>New password</h2>

<form accept-charset="UTF-8" role="form" method="post" id="newPasswordForm" class="narrow">

    <div class="form-group">
        <input class="form-control" placeholder="New password" name="password" type="password">
    </div>
    <div class="form-group">
        <input class="form-control" placeholder="Repeat password" name="password2" type="password">
    </div>

    <input class="btn btn-lg btn-success btn-block" type="submit" value="Submit">
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
</script>