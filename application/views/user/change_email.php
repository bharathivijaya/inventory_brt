<h2>Change email</h2>

                    <form accept-charset="UTF-8" role="form" method="post" id="emailform" class="narrow">

                            <div class="form-group">
                                <label>Enter your new email address</label>
                                <input class="form-control" placeholder="E-mail" name="email" type="text" id="email">
                            </div>

                            <input class="btn  btn-success " type="submit" value="Send">


                    </form>


<script>
    $(document).ready(function() {
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
