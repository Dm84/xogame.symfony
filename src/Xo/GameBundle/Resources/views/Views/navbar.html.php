<?php

$hiddenMixin = 'hidden';
$login_label = '';

if (isset($login) && !empty($login))
{
    $hiddenMixin = '';
    $login_label = $login;
}

?>
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">

        <p id="navbar-login" class="navbar-text <?php echo $hiddenMixin?>">
             <span class="glyphicon glyphicon-user"></span>
             <?php echo $login_label; ?>
        </p>
        
        
        
        
        <ul class="nav navbar-nav navbar-right">            
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Language<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="<?php echo $view['router']->generate('main', array('locale' => 'ru'))?>" class="noajax">Русский</a></li>
                    <li><a href="<?php echo $view['router']->generate('main', array('locale' => 'en'))?>" class="noajax">English</a></li>
                </ul>
            </li>
            <li><a class="btn" href="<?php echo $signout_url?>"><?php echo $lang->Signout()?></a></li>
        </ul>
    </div>        
</nav>
