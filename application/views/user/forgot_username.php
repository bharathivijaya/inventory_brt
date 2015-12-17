<h2>Forgot your username?</h2>

<form accept-charset="UTF-8" role="form" method="post" id="emailform" class="narrow">
    <div class="form-group">
        <label>Enter your email</label>
        <input class="form-control" placeholder="E-mail" name="email" type="text">
    </div>

    <input class="btn btn-lg btn-success btn-block" type="submit" value="Send">
</form>


<script>
    $(document).ready(function() {
        //$.noConflict();
        // console.log($('#loginform').html());
        $('#emailform').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {

                email: {
                    validators: {
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