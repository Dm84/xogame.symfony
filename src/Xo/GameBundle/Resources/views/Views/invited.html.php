<?php function RenderTemplate(Xo\GameBundle\Abstraction\ILanguage & $lang, $inviter, $accept_url) { ?>

    <div class="row">        
        <div class="col-xs-4">                    
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="h1">
                        <?php echo $lang->InviteAcceptHeader(); ?>
                    </h1></div>
                <div class="panel-body">
                    <?php echo $lang->InviteAcceptMessage().' '.$inviter;?>
                </div>
                <div class="panel-footer">
                    <form 
                        class="form" 
                        class="form-horizontal" 
                        role="form" method="post" 
                        action="<?php echo $accept_url;?>">
                        
                        <button class="btn btn-primary" type="submit" value="to_accept" name="action">
                            <?php echo $lang->Accept();?>
                        </button>
                        <button class="btn btn-warning" type="submit" value="to_decline" name="action">
                            <?php echo $lang->Decline();?>
                        </button>                        
                        
                    </form>    
                </div>                
            </div>            
        </div>
    </div>
<?php }
RenderTemplate($lang, $invitee, $accept_url);
