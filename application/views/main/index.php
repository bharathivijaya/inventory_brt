<div class="homepage">
    <div class="row" style="padding:20px;margin:0px">
        <div class="col-md-5 col-md-offset-1"  style="padding-top:90px">
            <div class="col-md-7" style="text-align: right">
                <img src="<?=base_url()?>images/book.jpg" alt="" width="230">
            </div>
            <div class="col-md-5 bookText">
                <p class="small" style="ca">
                    perpetual
                    inventory
                    made easier
                    with our
                </p>
                <p class="big">
                    Online
                    logbook
                </p>
            </div>
        </div>
        <div class="col-md-4" style="padding-top:40px" >

            <div class="mFont">
                <p class="mFont">sign up</p>
                <p class=" small" style="font-size: 75%;">it's fast, it's easy and it's <span class="label label-warning ">free</span> for limited time </p>
            </div>
                <form action="<?=base_url()?>user/register_company" method="post" id="signupform">
                    <div class="form-group">
                        <input type="text" name="cname" placeholder="Business Name" class="form-control smallFont mtop10">
                    </div>
                    <div class="form-group">
                        <div class="row" style="margin-left: -15px;margin-right: -15px;">
                            <div class="col-md-6" >
                                <input type="text" name="first_name" placeholder="First Name" class="form-control smallFont " required>
                            </div>
                            <div class="col-md-6" >
                                <input type="text" name="last_name" placeholder="Last Name" class="form-control smallFont " required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" id="email" placeholder="Email" class="form-control smallFont mtop10" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="username" id="username" placeholder="Username" class="form-control smallFont mtop10" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password" class="form-control smallFont mtop10" required>

                    </div>
                    <div class="form-group">
                        <input type="password" name="password2" placeholder="Confirm Password" class="form-control smallFont mtop10" required>

                    </div>
                    <div class="form-group">
                        <input type="text" name="npi" id="npi" placeholder="Enter valid 10 digit NPI" class="form-control smallFont mtop10" required>

                    </div>




                    <div class="row">
                        <div class="col-md-4 ">
                            <input type="submit" value="Register" class="btn btn-lg btn-warning mtop10">
                        </div>
                        <div class="col-md-8" style="padding-top:10px">
                            By clicking sign up you agree to our <a href="<?=base_url()?>main/policies">terms of use and privacy policy</a>
                        </div>
                    </div>

            </form>
            </div>

        </div>
    </div>
    <div class="homepage-footer">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div>
                    Get rid of the frustration and hassels of paper binders:
                </div>
                <div class="row mtop10">
                    <div class="col-md-4 mtop10">
                        <div>
                            <i class="fa fa-check yellowCheck"></i>
                            Create Your Own Custom Drug Catalog
                        </div>
                        <i class="fa fa-check yellowCheck"></i>
                            Enter Inventory Transactions
                    </div>
                    <div class="col-md-4 mtop10">
                        <i class="fa fa-check yellowCheck"></i>
                            Audit Inventory <br>
                        <i class="fa fa-check yellowCheck"></i>
                            Generate Reports
                    </div>
                    <div class="col-md-4 mtop10">
                        <i class="fa fa-check yellowCheck"></i>
                            Manage Users <br>
                        <i class="fa fa-check yellowCheck"></i>
                            No Software to Install
                    </div>
                </div>
            </div>
        </div>

    </div>



<script type="text/javascript" src="https://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "3673cd0f-0921-45ae-afde-33b0d13282ec", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
<script>
    $(document).ready(function() {
        $('#signupform').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                npi: {
                    message: 'NPI is not valid',
                    validators: {
                        remote: {
                            url: '<?=base_url()?>user/checkNpi/'+$('#npi').val(),
                            data: function(validator) {
                                return {
                                    username: validator.getFieldElements('username').val()
                                };
                            },
                            message: 'NPI is not available'
                        },
                        notEmpty: {
                            message: 'NPI is required and cannot be empty'
                        },
                        stringLength: {
                            min: 10,
                            max: 10,
                            message: 'NPI must be 10 characters long'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'NPI can only consist of numerical characters'
                        }
                    }
                },

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

