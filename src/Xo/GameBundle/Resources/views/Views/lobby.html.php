<?php echo $view->render('XoGameBundle:Views:scripts.html.php', array('login' => $login));

function RenderLobby($login, $players, \Xo\GameBundle\Abstraction\ILanguage $lang, $inviter, $invitee, $invite_url, 
		$cancel_url, $accept_url, $decline_url, $keepalive_url, $main_url, $quit_url) {?>

<script type="text/javascript">
	
	var modalsEnabled = 0, keepalive = 0;
	
	var showAwaitingModal = function (invitee) {
			
		if (!modalsEnabled)
		{
			$('#awaiting-modal .body').text('<?php echo $lang->AcceptAwaitingMessage()?>: '+invitee);
			$('#awaiting-modal').modal();
		}		
	};
	
	var showAcceptModal = function (inviter) {

		if (!modalsEnabled)
		{
			$('#accept-modal .body').text('<?php echo $lang->InviteAcceptMessage()?>: '+inviter);
			$('#accept-modal').modal();
		}	
		
	};
	
	var hideAwaitingModal = function () {					
			
		$('#awaiting-modal').data('prevent-send-cancel', true).modal('hide');		
	};
	
	var hideAcceptModal = function () {					
			
		$('#accept-modal').data('prevent-send-cancel', true).modal('hide');		
	};

	var handlers = {
		
		player_online: function (data) {
			
			var id = 'player-'+data.login;		
			
			if ($('#'+id).length === 0) 
			{				
				$newItem = $('.panel-body .list-group-item.hidden').clone();	

				$newItem.attr('id', id);

				$('.h5', $newItem).append(data.login);

				if (data.login === '<?php echo $login?>')
					$('a.btn', $newItem).remove();
				else					
					$('a.btn', $newItem).attr('href', '<?php echo $invite_url?>?invitee=' + data.login);

				$newItem.appendTo('.panel-body .list-group');
				$newItem.removeClass('hidden');
				
				$('a.btn', $newItem).click(function (e) {
			
					e.preventDefault();
					send($(this).attr('href'));
				});				
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
			showInfoMessage('<?php echo $lang->CancelNotify()?> - ' + data.inviter);
		},
		
		declined: function (data)
		{
			hideAwaitingModal();			
			showInfoMessage('<?php echo $lang->DeclineNotify()?> - ' + data.invitee);
		},
				
		accepted: function (data)
		{
			hideAcceptModal();
			hideAwaitingModal();
			
			clearInterval(keepalive);
			getContent('<?php echo $main_url?>');
		}
		
	};	
	
</script>
<script type="text/javascript">
	
	/*events*/	
	$(function ()
	{		
		$('.list-group a.btn').click(function (e) {

			e.preventDefault();
			send($(this).attr('href'));
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

			if (!$(this).data('prevent-send-cancel')) send('<?php echo $decline_url?>');			
			--modalsEnabled;			
		});
		
		$('#awaiting-modal').on('hidden.bs.modal', function (e) {

			if (!$(this).data('prevent-send-cancel')) send('<?php echo $cancel_url?>');			
			--modalsEnabled;
		});		
		
		$("#awaiting-modal a.btn").click(function (e) {			
			e.preventDefault();
			send($(this).attr('href'));			
			hideAwaitingModal();			
		});

		$("#accept-btn").click(function (e) {			
			e.preventDefault();
			clearInterval(keepalive);
			getContent($(this).attr('href'));			
			hideAcceptModal();			
		});

		$("#decline-btn").click(function (e) {			
			e.preventDefault();			
			send($(this).attr('href'));			
			hideAcceptModal();			
		});
		
		$(window).bind("beforeunload", function(evt) {
			
			loaderIn();
			$.ajax('<?php echo $quit_url?>', {
				
				async: false,
				complete: function () { loaderOut(); }
			});
			
			return '';			
		});
		
		
		keepalive = setInterval(function () {
			
			send('<?php echo $keepalive_url?>');
			
		}, 60000);
				
		
		<?php if ($inviter !== null):?>
			showAcceptModal('<?php echo $inviter?>');
		<?php endif;?>

		<?php if ($invitee !== null):?>
			showAwaitingModal('<?php echo $invitee?>');
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
		  <h4 class="modal-title" id="myModalLabel"><?php echo $lang->InviteAcceptHeader()?></h4>
		</div>
		<div class="modal-body">			
		</div>
		<div class="modal-footer">
			<a id="accept-btn" class="btn btn-primary" href="<?php echo $accept_url?>"><?php echo $lang->Accept()?></a>
			<a id="decline-btn" class="btn btn-default" href="<?php echo $decline_url?>"><?php echo $lang->Decline()?></a>
		</div>
	  </div>
	</div>
</div>

<div class="modal fade" id="awaiting-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		  <h4 class="modal-title" id="myModalLabel"><?php echo $lang->AcceptAwaitingHeader()?></h4>
		</div>
		<div class="modal-body">
		</div>
		<div class="modal-footer">
			<a class="btn btn-default" href="<?php echo $cancel_url?>"><?php echo $lang->Cancel()?></a>
		</div>
	  </div>
	</div>
</div>


<div class="col-lg-4 col-lg-offset-4">					
	<div class="panel panel-default">
		<div class="panel-heading">
			<h1 class="h1">
				<?php echo $lang->LobbyPlayersList()?>
				<span class="badge" style="vertical-align: top;"></span>
			</h1>					
		</div>
		<div class="panel-body">					

				<div class="list-group-item hidden">	
					<a href="" class="btn btn-primary pull-right">
					 <?php echo $lang->ToInvite();?>
					</a>
					<div class="h5">
						<span class="glyphicon glyphicon-user"></span>
					</div>

					<div class="clearfix"></div>
				</div> 

				<div class="list-group">
					<?php foreach ($players as $player):								
						if ($player instanceof \Xo\GameBundle\Entity\LobbyPlayer):
					?>
					<div class="list-group-item" id="player-<?php echo $player->login?>">
					<?php if ($player->login !== $login):?>
						<a href="<?php echo $invite_url.'?invitee='.$player->login?>" class="btn btn-primary pull-right">
							<?php echo $lang->ToInvite()?>
						</a>
					<?php endif; ?>	
						<div class="h5">
							<span class="glyphicon glyphicon-user"></span>
							<?php echo $player->login; ?>
						</div>							
						<div class="clearfix"></div>

					</div>
					<?php endif; endforeach; ?>
				</div>				  

		</div>
	</div>			
</div>

<?php }
	
 RenderLobby($login, $players, $lang, $inviter, $invitee, 
		 $invite_url, $cancel_url, $accept_url, $decline_url, $keepalive_url, $main_url, $quit_url);