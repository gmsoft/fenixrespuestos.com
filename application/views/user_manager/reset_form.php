<?php $this->load->view('user_manager/header');?>
<form class="form-resert" action="reset" method="POST">
    <div class="lock-header">
        <!-- BEGIN LOGO -->
        <a class="center" id="logo" href="index.html">
            <img class="center" alt="logo" src="<?php echo base_url() . 'assets/img/logo.png' ?>" />
        </a>
        <!-- END LOGO -->
    </div>
    <div class="login-wrap">
        <div class="metro single-size red">
            <div class="locked">
                <i class="icon-lock"></i>
                <span>Resetear</span>
            </div>
        </div>
        <div class="metro double-size green">
                <div class="input-append lock-input">
                    <input placeholder="Ingrese su email" type="text" name="email" value="<?php echo $email ?>" />
                    <?php echo form_error('email'); ?>
                </div>
        </div>
        <div class="metro double-size yellow">
                <button type="submit" class="btn login-btn" value="reset" name="submit">
                    Enviar
                    <i class=" icon-long-arrow-right"></i>
                </button>
        </div>
        <div class="metro single-size terques login">
              <a class="btn login-btn" href="<?php echo base_url();?>ingresar">Volver</a></p>
        </div>
    </div>
</form>
<?php $this->load->view('user_manager/footer');?>