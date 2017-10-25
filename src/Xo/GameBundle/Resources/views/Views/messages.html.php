<?php




foreach ($messages as $message)
{    
    if ($message->type === 'error') { ?>
        <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign"></span> 
                <?php echo $message->body?>
        </div>    
    <?php } elseif($message->type === 'info') { ?>
        <div class="alert alert-info" role="alert">
            <span class="glyphicon glyphicon-info-sign"></span> 
                <?php echo $message->body?>
        </div>
    <?php }
}
