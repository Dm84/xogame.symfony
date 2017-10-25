                <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert"><strong>Error:</strong> <?php echo $error?></div>    
                <?php endif; ?>
                <?php if (isset($info)): ?>
                <div class="alert alert-info" role="alert"><?php echo $info?></div>    
                <?php endif; ?>