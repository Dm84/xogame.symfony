<?php
    
    /* @var $model Xo\GameBundle\View\LobbyModelView */
?>

<script type="text/javascript">
    
    var modalsEnabled = 0, keepalive = 0;
    
    var showAwaitingModal = function (invitee) {
            
        if (!modalsEnabled)
        {
            $('#awaiting-modal .modal-body').text('<?php echo $model->lang->AcceptAwaitingMessage()?>: '+invitee);
            $('#awaiting-modal').modal();
        }        
    };
    
    var showAcceptModal = function (inviter) {

        if (!modalsEnabled)
        {
            $('#accept-modal .modal-body').text('<?php echo $model->lang->InviteAcceptMessage()?>: '+inviter);
            $('#accept-modal').modal();
        }    
        
    };
    
    var hideAwaitingModal = function () {                    
            
        $('#awaiting-modal').data('prevent-send-cancel', true).modal('hide');        
    };
    
    var hideAcceptModal = function () {                    
            
        $('#accept-modal').data('prevent-send-cancel', true).modal('hide');        
    };

    handlers = {
        
        player_online: function (data) {
            
            var id = 'player-'+data.login;        
            
            if ($('#'+id).length === 0) 
            {                
                var $newItem = $('.panel-body .list-group-item.hidden').clone().attr('id', id);
                $('.h5', $newItem).append(data.login);

                if (data.login === '<?php echo $model->login?>')
                    $('.btn', $newItem).remove();
                else                    
                    $('.btn', $newItem).data('href', '<?php echo $model->invite_url?>?invitee=' + data.login);

                $('.btn', $newItem).click(function (e) {
                    send($(this).data('href'), handlers);
                });

                $newItem.appendTo('.panel-body .list-group').removeClass('hidden');
            }
        },
            
        leaved: function (data) {
            
            for (i in data.logins)
            {        
                $('#player-'+data.logins[i]).remove();
            }
            
        },
        
        invited: function (data) {
            showAcceptModal(data.inviter);
        },
        
        invite: function (data)
        {
            showAwaitingModal(data.invitee);
        },
        
        canceled: function (data)
        {
            hideAcceptModal();            
            showInfoMessage('<?php echo $model->lang->CancelNotify()?> - ' + data.inviter);
        },
        
        declined: function (data)
        {
            hideAwaitingModal();            
            showInfoMessage('<?php echo $model->lang->DeclineNotify()?> - ' + data.invitee);
        },
                
        accepted: function (data)
        {
            hideAcceptModal();
            hideAwaitingModal();
            
            clearInterval(keepalive);
            getContent('<?php echo $model->main_url?>');
        }
        
    };    
    
</script>
<script type="text/javascript">
    
    /*events*/    
    $(function ()
    {        
        $('.list-group .btn').click(function (e) {
            e.preventDefault();
            send($(this).data('href'), handlers);
        });    
        
        $('#awaiting-modal').on('shown.bs.modal', function (e) {

            $(this).data('prevent-send-cancel', false);
            ++modalsEnabled;

        });

        $('#accept-modal').on('shown.bs.modal', function (e) {

            $(this).data('prevent-send-cancel', false);
            ++modalsEnabled;

        });

        $('#accept-modal').on('hidden.bs.modal', function (e) {

            if (!$(this).data('prevent-send-cancel')) send('<?php echo $model->decline_url?>', handlers);            
            --modalsEnabled;            
        });
        
        $('#awaiting-modal').on('hidden.bs.modal', function (e) {

            if (!$(this).data('prevent-send-cancel')) send('<?php echo $model->cancel_url?>', handlers);            
            --modalsEnabled;
        });        
        
        $("#awaiting-modal .btn").click(function (e) {
            e.preventDefault();
            send($(this).data('href'), handlers);
            hideAwaitingModal();            
        });

        $("#accept-btn").click(function (e) {            
            e.preventDefault();
            clearInterval(keepalive);
            getContent($(this).data('href'), handlers);
            hideAcceptModal();            
        });

        $("#decline-btn").click(function (e) {            
            e.preventDefault();            
            send($(this).data('href'), handlers);
            hideAcceptModal();            
        });
        
        $(window).off("beforeunload").on("beforeunload", function(evt) {
            
            loaderIn();
            $.ajax('<?php echo $model->quit_url?>', {
                
                async: false,
                success: function () { loaderOut(); },
                complete: function () {}
            });
            
            return null;
        });
        
        keepalive = setInterval(function () {
            
            send('<?php echo $model->keepalive_url?>', handlers, false);
            
        }, 60000);
        
        <?php if ($inviter !== null):?>
            showAcceptModal('<?php echo $model->inviter?>');
        <?php endif;?>

        <?php if ($invitee !== null):?>
            showAwaitingModal('<?php echo $model->invitee?>');
        <?php endif;?>
        });
            
</script>

<div class="modal fade" id="accept-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span>
              <span class="sr-only">Close</span>
          </button>
          <h4 class="modal-title" id="myModalLabel"><?php echo $model->lang->InviteAcceptHeader()?></h4>
        </div>
        <div class="modal-body">            
        </div>
        <div class="modal-footer">
            <button id="accept-btn" class="btn btn-primary" data-href="<?php echo $model->accept_url?>"><?php echo $model->lang->Accept()?></button>
            <button id="decline-btn" class="btn btn-default" data-href="<?php echo $model->decline_url?>"><?php echo $model->lang->Decline()?></button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="awaiting-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel"><?php echo $model->lang->AcceptAwaitingHeader()?></h4>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
            <button class="btn btn-default" data-href="<?php echo $model->cancel_url?>">
                <?php echo $model->lang->Cancel()?>
            </button>
        </div>
      </div>
    </div>
</div>


<div class="col-lg-4">                    
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="h1">
                <?php echo $model->lang->LobbyPlayersList()?>
                <span class="badge" style="vertical-align: top;"></span>
            </h1>                    
        </div>
        <div class="panel-body">                    

                <div class="list-group-item hidden">    
                    <button data-href="" class="btn btn-primary pull-right">
                     <?php echo $model->lang->ToInvite();?>
                    </button>
                    <div class="h5">
                        <span class="glyphicon glyphicon-user"></span>
                    </div>

                    <div class="clearfix"></div>
                </div> 

                <div class="list-group">
                    <?php foreach ($players as $player):                                
                        if ($player instanceof \Xo\GameBundle\Entity\LobbyPlayer):
                    ?>
                    <div class="list-group-item" id="player-<?php echo $model->player->login?>">
                    <?php if ($player->login !== $login):?>
                        <button data-href="<?php echo $model->invite_url.'?invitee='.$player->login?>" class="btn btn-primary pull-right">
                            <?php echo $model->lang->ToInvite()?>
                        </button>
                    <?php endif; ?>    
                        <div class="h5">
                            <span class="glyphicon glyphicon-user"></span>
                            <?php echo $model->player->login; ?>
                        </div>                            
                        <div class="clearfix"></div>

                    </div>
                    <?php endif; endforeach; ?>
                </div>                  

        </div>
    </div>            
</div>

<?php

echo $model->view->render('XoGameBundle:Views:scripts.html.php', array('login' => $model->login, 'lang' => $model->lang)); 