<?php
    
    /* @var $model Xo\GameBundle\View\SigninViewModel */

?>
    <script type="text/javascript" src="/bundles/xogame/js/jquery.form.js"></script>
    <script type="text/javascript" src="/bundles/xogame/js/jquery.validate.js"></script>
    <script type="text/javascript">
        
        $(function () {
    /*        
            $('#signup input[name="password-dub"], #signup input[name="password"]').keyup(function () {
                
                console.log('change');
                
                var $pas = $('#signup input[name="password"]'), $pas_dub = $('#signup input[name="password-dub"]');
                            
                
                if ($pas.val() !== $pas_dub.val())
                {
                    $pas.parent().addClass('has-error');
                    $pas_dub.parent().addClass('has-error');
                    
                } else
                {
                    $pas.parent().removeClass('has-error');
                    $pas_dub.parent().removeClass('has-error');
                }
                
            });
    */
   

            var shared_settings = {                
                
                errorPlacement: function(error, element) {
                    error.insertBefore(element);
                },
                
                highlight: function(element, errorClass) {
                     
                    $(element).parent().addClass('has-error');
                },
                
                unhighlight: function(element, errorClass) {
                     
                    $(element).parent().removeClass('has-error');
                },                
                
                errorClass: 'control-label'
            };
            
            var handleSuccess = function (data) {
                handleMessages(data.messages);
                if (typeof data.response !== 'undefined') 
                {                    
                    $('#navbar-login').removeClass('hidden').append(data.response.login);
                    $('#content').html(data.response.html);
                }     
                
            };
            
            var submitHandler = function(form) {
                    
                loaderIn();

                $(form).ajaxSubmit({

                    dataType: 'json',
                    success: function(data) {
                        handleSuccess(data);
                    },
                    complete: function () { loaderOut(); }
                 });
            };

            $('#signin').validate($.extend({

                rules: {
                    
                    login: {
                        required: true
                    },
                    password: {
                        required: true
                    }                    
                },

                messages: {
                    
                    login: {
                        required: '<?php echo $model->lang->FieldRequired()?>'
                    },
                    password: {
                        required: '<?php echo $model->lang->FieldRequired()?>'
                    }
                    
                },
                    
                submitHandler: submitHandler
                    
                
            }, shared_settings));

            var res = $('#signup').validate($.extend({
                
                onkeyup: function (element, event) { 
                    if ($(element).hasClass('onkeyup')) $(element).valid();
                    else if ($(element).attr('id') === 'password' && $('#password-confirm').val() !== '') 
                        $('#password-confirm').valid();
                },
                
                messages: {
                    
                    password: {
                        minlength: '<?php echo $model->lang->PasswordLengthRequirement() ?> 5',
                        required: '<?php echo $model->lang->FieldRequired()?>'
                    },
                    
                    password_confirm: {
                        equalTo: '<?php echo $model->lang->PasswordConfirmRequirement()?>'
                    },
                    
                    login: {
                        required: '<?php echo $model->lang->FieldRequired()?>'
                    }
                },
                
                rules: {

                    login: {
                        required: true
                    },

                    password: {
                        required: true,                                    
                        minlength: 1
                    },
                    password_confirm: {                        
                        equalTo: '#password'
                    }
                },
                
                submitHandler: submitHandler

            }, shared_settings)); 
  
        });
        
    </script>
    

<div class="col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="h1">
            <?php echo $model->lang->SigninFormHeader(); ?>
            </h1>
        </div>
        <div class="panel-body">
            <form id="signin" class="form" role="form" method="post" action="<?php echo $model->signin_url?>">
                <div class="form-group">
                    <input 
                        type="text" 
                        class="form-control" 
                        value="<?php echo $model->login ?>" 
                        name="login" 
                        placeholder="<?php echo $model->lang->LoginPlaceholder();?>"/>
                </div>
                <div class="form-group">
                    <input 
                        type="password" 
                        class="form-control" 
                        name="password" 
                        placeholder="<?php echo $model->lang->PasswordPlaceholder();?>"/>
                </div>
                <button 
                    class="btn btn-primary" 
                    type="submit" 
                    value="to_signin" 
                    name="action">
                        <?php echo $model->lang->Signin();?>
                </button>
            </form>            
        </div>
    </div>
</div>
<div class="col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="h1">
            <?php echo $model->lang->SignupFormHeader(); ?>
            </h1>
        </div>
        <div class="panel-body">
            <form id="signup" class="form" role="form" method="post" action="<?php echo $model->signup_url?>">
                <div class="form-group">
                    <input 
                        type="text" 
                        class="form-control" 
                        value="<?php echo $login ?>" 
                        name="login" 
                        placeholder="<?php echo $model->lang->LoginPlaceholder();?>"/>
                </div>
                <div class="form-group">
                    <input
                        id="password"
                        type="password" 
                        class="form-control" 
                        name="password" 
                        placeholder="<?php echo $model->lang->PasswordPlaceholder();?>"/>
                </div>
                <div class="form-group">
                    <input
                        id="password-confirm"
                        type="password" 
                        class="form-control onkeyup" 
                        name="password_confirm" 
                        placeholder="<?php echo $model->lang->PasswordPlaceholderConfirm() ?>"/>
                </div>

                <button 
                    class="btn btn-primary" 
                    type="submit" 
                    value="to_signin" 
                    name="action">
                        <?php echo $model->lang->Signup();?>
                </button>
            </form>            
        </div>
    </div>
</div>