<?php
function RenderTemplate(\Xo\GameBundle\Abstraction\ILanguage & $lang, $invitee, $cancel_url) { ?>
    <div class="row">        
        <div class="col-lg-4 col-lg-offset-4">                    
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="h1">
                        <?php echo $lang->AcceptAwaitingHeader()?>
                    </h1>
                </div>
                <div class="panel-body">
                    <?php echo $lang->AcceptAwaitingMessage().' '.$invitee;?>
                </div>
                <div class="panel-footer">
                    <a class="btn btn-primary" href="<?php echo $cancel_url; ?>">
                        <?php echo $lang->Cancel();?>
                    </a>                        
                    
                </div>
            </div>            
        </div>
    </div>
<?php }
RenderTemplate($lang, $invitee, $cancel_url);