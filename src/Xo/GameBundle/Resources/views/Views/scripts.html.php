<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<script type="text/javascript">
    
    //var handlers = {};

    if (typeof userChan === 'undefined')
    {
        var handleHydnaNotify = function (event)
        {
            //console.log('incoming: ', event.data);
            
            var obj = JSON.parse(event.data);
            handleNotice(obj, handlers);
        };

        var onHydnaError = function (e) {
        
            showErrorMessage('<?php echo $lang->ErrorConnection()?>: http://xoapp.hydna.net: ' + e.data);        
        };


        // first we open a channel on the domain `public.hydna.net` in read-
        // and write mode.
        var sharedChan = new HydnaChannel('xoapp.hydna.net/shared', 'r');
        var userChan = new HydnaChannel('xoapp.hydna.net/user/<?php echo $login?>', 'r');

        // then register an event handler that alerts the data-part of messages 
        // as they are received.
        sharedChan.onmessage = onHydnaError;
        userChan.onmessage = onHydnaError;

        // an error occured when connecting or opening the channel
        sharedChan.onerror = onHydnaError;
        userChan.onerror = onHydnaError;

        sharedChan.onclose = onHydnaError;

        sharedChan.onopen = function () {
            sharedChan.onmessage = handleHydnaNotify;
            userChan.onmessage = handleHydnaNotify;
            console.log('hydna open ok');
        };

        console.log('hydna init');

    } else
    {
        console.log('no hydna init');
    }

    
</script>