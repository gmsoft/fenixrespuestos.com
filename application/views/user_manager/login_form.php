<?php $this->load->view('user_manager/header');?>
<form class="form-signin" action="ingresar" method="POST">
    <div class="lock-header">
        <!-- BEGIN LOGO -->
        <a class="center" id="logo" href="index.html">
            <img class="center" alt="logo" src="<?php echo base_url() . 'assets/img/logo.png' ?>" />
        </a>
        <!-- END LOGO -->
    </div>
    
    <?php 
    if (isset($msg)){
    ?>
    <div id="message-box">
        <div class="alert alert-error">
        <?php
        echo $msg; 
        ?>
        </div>
    </div>
    <?php
    }
    ?>
    
    
    <div class="login-wrap">
        <div class="metro single-size red">
            <div class="locked">
                <i class="icon-lock"></i>
                <span>Login</span>
            </div>
        </div>
        
        <div class="metro double-size green">
                <div class="input-append lock-input">
                    <input placeholder="<?php echo $this->lang->line('um_username'); ?>" name="username" type="text" value="<?php echo $username ?>" />
                    <?php echo form_error('username'); ?>
                </div>
        </div>
        <div class="metro double-size yellow">
                <div class="input-append lock-input">
                    <input placeholder="<?php echo $this->lang->line('um_password'); ?>" name="password" type="password" value="" />
                    <?php echo form_error('password'); ?>
                </div>
        </div>
         <div class="metro double-size red">
                <div class="input-append lock-input">
                    <label>Sucursal</label>
                    <select name="sucursal">
                        <option value="1">Centro</option>
                        <option value="2">Sucursal 2</option>
                    </select>    
                </div>
        </div>
        <div class="metro single-size terques login">
                <button type="submit" class="btn login-btn" name="login">
                    Login
                    <i class=" icon-long-arrow-right"></i>
                </button>
        </div>
        
        
        <div class="msg-">
            <div class="forgot-hint pull-right">
               
            </div>
        </div>
    </div>
      
</form>


<?php $this->load->view('user_manager/footer');?>