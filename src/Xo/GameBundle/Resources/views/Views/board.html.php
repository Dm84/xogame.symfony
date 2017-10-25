<?php
    /* @var $model Xo\GameBundle\View\BoardViewModel */

    $k = 0;
    $replay_btn_class = ($model->can_replay === true) ? '' : 'hidden';
    
    $zero = '<span style="display: block; margin: auto; text-align: center;" class="glyphicon glyphicon-ok-circle"></span>';
    $cross = '<span style="display: block; margin: auto; text-align: center;" class="glyphicon glyphicon-remove"></span>';
    
    function printToken($token, $zero, $cross)
    {
        if ($token === 'o')
        {
            echo $model->zero;
        } else
        {
            echo $model->cross;
        }
    }
    
    
    
?>

<div class="modal fade" id="replay-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel"><?php echo $model->lang->BoardReplayModalHeader()?></h4>
        </div>
        <div class="modal-body">
            <?php echo $model->lang->BoardReplayModalBody()?>
        </div>
        <div class="modal-footer">
            <button id="modal-accept-btn" class="btn btn-primary" data-href="<?php echo $model->accept_replay_url?>"><?php echo $model->lang->Accept()?></button>
            <button id="modal-leave-btn" class="btn btn-default" data-href="<?php echo $model->leave_url?>"><?php echo $model->lang->BoardLeave()?></button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="accept-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel"><?php echo $model->lang->BoardReplayAcceptModalHeader()?></h4>
        </div>
        <div class="modal-body">
            <?php echo $model->lang->BoardReplayAcceptModalBody()?>
        </div>
      </div>
    </div>
</div>


<div class="col-lg-4">            
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="h1">
            <?php echo $model->lang->BoardHeader(); ?>
            </h1>
        </div>
        <div class="panel-body">                    
            <table class="table-bordered" style="width: 150px; height: 150px; margin: auto;">
                <?php for ($y = 0; $y < 3; ++ $y):?>
                <tr>
                    <?php for ($x = 0; $x < 3; ++ $x):?>
                    <td class="make-move" data-cell="<?php echo $k;?>" id="cell-<?php echo $k?>"
                        data-href="<?php echo $model->make_move_url.'?cell='.$k;?>"
                        style="font-size: 30px; width: 33%; height: 33%;" class="text-center">
                        <?php 
                        if (isset($model->board[$k]))
                        {
                            printToken($model->board[$k], $zero, $cross);

                        }
                        ?>
                    </td>
                    <?php ++$k; endfor;?>
                </tr>
                <?php endfor?>
            </table>
        </div>

        <div class="panel-footer">
            <button id="leave-btn" data-href="<?php echo $model->leave_url;?>" class="btn btn-primary">
                <?php echo $model->lang->BoardLeave();?>
            </button>
            <button id="replay-btn" data-href="<?php echo $model->replay_url;?>" 
                    class="btn btn-default <?php echo $model->replay_btn_class?>">
                <?php echo $model->lang->BoardReplay();?>
            </button>
        </div>                
    </div>    
</div>


<script type="text/javascript">

    var move = {
        make: function (cell) {

            disableBoard();
            this.cell = cell;
            $('#cell-'+this.cell).html('<?php printToken($token, $zero, $cross)?>');
        },
                
        cancel: function () {

            enableBoard();
            console.log('move not accepted');
            $('#cell-'+this.cell).html('');
        }
    };

    var enableBoard = function () {

        $('.make-move').css('cursor', 'pointer').click(function(e)
        {
            move.make($(this).data('cell'));
            send($(this).data('href'), handlers, false, function (response) {
                if (move.cell !== response.body.cell)
                {
                    move.cancel();
                }

            }, function () { move.cancel(); console.log('move error'); });
        });
    };

    var disableBoard = function () {
        $('.make-move').css('cursor', 'default').off('click');
    };

    var stateHandler = function (data)
    {
        console.log(data);        
    
        //has move
        if (data.cell !== 'undefined')
        {
            var token = data.cellToken === 'o' ? '<?php echo $model->zero;?>' : '<?php echo $model->cross;?>';
            $('#cell-'+data.cell).removeClass('make-move').html(token);
        }
        
        if (data.state.canMove) { enableBoard(); } else { disableBoard(); }
        if (data.state.canReplay) { $('#replay-btn').removeClass('hidden'); }        
    };

    //notices
    handlers = {
        
        your_move: function (data) {
            stateHandler(data);
            showInfoMessage('<?php echo $model->lang->BoardYourMove(); ?>');
        },
                
        rivals_move: function (data) {
            stateHandler(data);
            showInfoMessage('<?php echo $model->lang->BoardRivalsMove(); ?>');
        },
                
        win: function (data) {
            stateHandler(data);
            showInfoMessage('<?php echo $model->lang->BoardWin()?>');
        },
                
        loss: function (data) {            
            stateHandler(data);
            showInfoMessage('<?php echo $model->lang->BoardLoss(); ?>');            
        },
                
        draw: function (data) {
            stateHandler(data);
            showInfoMessage('<?php echo $model->lang->BoardDraw(); ?>');
        },
                
        replay: function (data) {
            $('#replay-modal').modal();    
        },
                
        accept_replay: function (data)
        {
            $('#accept-modal').modal('hide');
            getContent('<?php echo $model->main_url?>');
        },
                
        leave_game: function (data)
        {
            $('#accept-modal').modal('hide');
            $('#replay-btn').hide();
            disableBoard();
            showInfoMessage('<?php echo $model->lang->BoardLeft();?>');
        }
        
    };

    //events
    $(function () {
    
//        $('#replay-modal').on('hidden-bs-modal', function () {
//            getContent('<?php echo $model->leave_url ?>');
//        });
        
        $('#leave-btn, #modal-leave-btn').click(function (e) {
            e.preventDefault();
            $('#replay-modal').data('prevent-leave', true).modal('hide');
            getContent('<?php echo $model->leave_url ?>');
        });
        
        $('#replay-modal').on('hidden.bs.modal', function (e) {
            
            if ($(this).data('prevent-leave') !== true)
            {
                getContent('<?php echo $model->leave_url ?>');
            }
            $(this).data('prevent-leave', false);
        });
        
        $('#replay-btn').click(function (e) {            
            e.preventDefault();
            $('#accept-modal').modal();
            send($(this).data('href'), handlers);
        });
        
        $('#modal-accept-btn').click(function (e) {            
            e.preventDefault();
            $('#replay-modal').data('prevent-leave', true).modal('hide');
            getContent('<?php echo $model->accept_replay_url; ?>');
        });
        
        <?php if (!$can_move): ?>
            disableBoard();
        <?php else: ?>
            enableBoard();
        <?php endif; ?>

        $(window).off("beforeunload").on("beforeunload", function(evt) {
            
            loaderIn();
            $.ajax('<?php echo $model->quit_board_url?>', {
                
                async: false,
                success: function () {  },
                complete: function () { loaderOut(); }
            });
            
            return null;
        });
        
    });

</script>


<?php

$model->view->render('XoGameBundle:Views:scripts.html.php', array('login' => $login, 'lang' => $lang));