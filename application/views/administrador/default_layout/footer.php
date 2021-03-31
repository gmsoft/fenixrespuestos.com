</div>
    <footer>
        Fenix Repuestos
    </footer>

<!-- Modal de Agenda de Contactos -->
<div id="modal-agenda-contactos" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>Agenda de Contactos</h3>
    </div>
    <div class="modal-body" id="body-agenda-contactos">
        <div class="row-fluid">
            <div class="span4">
                <div class="control-group">
                    <!--<label class="control-label">Articulo</label>-->
                    <div class="controls controls-row">
                        <input type="text" class="input-block-level" placeholder="Nombre" id="nombre-contacto" value="">
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <div class="controls controls-row">
                        <input type="text" class="input-block-level" placeholder="Telefono" id="telefono-contacto" value="">
                    </div>
                </div>
            </div>
             <div class="span4">
                <div class="control-group">
                    <div class="controls controls-row">
                        <input type="text" class="input-block-level" placeholder="E-mail" id="email-contacto" value="">
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <div class="controls controls-row">
                        <input type="text" class="input-block-level" placeholder="Direccion" id="direccion-contacto" value="">
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn" id="btn-agregar-contacto">Agregar Contacto</button>
        <hr/>
        <div id="tabla-contactos">

        </dv>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    </div>
    <input type="hidden" id="entidad-field">
    <input type="hidden" id="campo-field">
    <input type="hidden" id="valor_id-field">
</div>

</body>
<?php foreach($js_files as $file): ?>
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?> 
<script src="<?=base_url()?>assets/js/jquery.nicescroll.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=base_url()?>assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.maskedinput-1.2.2.js"></script>
 
 <!-- ie8 fixes -->
 <!--[if lt IE 9]>
 <script src="js/excanvas.js"></script>
 <script src="js/respond.js"></script>
 <![endif]-->
 
<script src="<?=base_url()?>assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/js/jquery.sparkline.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/js/chart-master/Chart.js"></script>
 
<!--common script for all pages-->
<script src="<?=base_url()?>assets/js/common-scripts.js"></script>
<!-- END JAVASCRIPTS -->
</html>
<script>
function addMotivo(valor)
{
    $('#aviso').val(valor);
    $('#myModal').modal('show');
}
var reader = new FileReader();

$('#file-import').change(function(){
      reader.readAsDataURL(document.getElementById("file-import").files[0]);
      reader.file = document.getElementById("file-import").files[0];
});

reader.onload = function (event) {
     var file = this.file; // there it is!
    
     document.getElementById("field-nombre_archivo").value = file.name;
};
/*Solo numericos
$('#field-cuit').keyup(function (){
    this.value = (this.value + '').replace(/[^0-9]/g, '');
});*/

//Aplica Mascara a CUIT
//$('#field-cuit').mask("99-99999999-9");

$('#field-cuit').blur(function(){
    var cuit = $('#field-cuit').val();
    var tipoIva = $('#field-iva_id :selected').text();
    
    if (tipoIva == 'Responsable Inscripto'
        || tipoIva == 'Monotributo') {
        ValidarCuit(cuit);
    }
});

$('#field-codigo_postal').blur(function(){
    var cpa = $('#field-codigo_postal').val();
        
    if (cpa != '') {
        if(!isValidCPA(cpa)) {
           alert('Código Postal no válido'); 
        }

    }

});

function ValidarCuit(cuit)  
{ 
    cuit = cuit.replace('-','');
    var vec = new Array(10); 
    esCuit = false; 
    cuit_rearmado = ""; 
    errors = '' 
    for (i=0; i < cuit.length; i++) 
    {    
        caracter=cuit.charAt( i); 
        if ( caracter.charCodeAt(0) >= 48 && caracter.charCodeAt(0) <= 57 ) 
        { 
            cuit_rearmado +=caracter; 
        } 
    } 
    cuit=cuit_rearmado; 
    if ( cuit.length != 11) {  // si no estan todos los digitos 
        esCuit=false; 
        errors = 'Cuit < 11 '; 
        //alert( "CUIT Menor a 11 Caracteres" ); 
        $('#msg-error-cuit').html('CUIT Menor a 11 Caracteres');
    } else { 
        x=i=dv=0; 
        // Multiplico los dígitos. 
        vec[0] = cuit.charAt(  0) * 5; 
        vec[1] = cuit.charAt(  1) * 4; 
        vec[2] = cuit.charAt(  2) * 3; 
        vec[3] = cuit.charAt(  3) * 2; 
        vec[4] = cuit.charAt(  4) * 7; 
        vec[5] = cuit.charAt(  5) * 6; 
        vec[6] = cuit.charAt(  6) * 5; 
        vec[7] = cuit.charAt(  7) * 4; 
        vec[8] = cuit.charAt(  8) * 3; 
        vec[9] = cuit.charAt(  9) * 2; 

        // Suma cada uno de los resultado. 
        for( i = 0;i<=9; i++)  
        { 
            x += vec[i]; 
        } 
        dv = (11 - (x % 11)) % 11; 
        if ( dv == cuit.charAt( 10) ) 
        { 
            esCuit=true; 
        } 
    } 
    if ( !esCuit )  
    { 
        
        $('#msg-error-cuit').fadeIn( "slow", function() {
            // Animation complete
            $('#msg-error-cuit').html('CUIT NO VÁLIDO');
            $('#msg-error-cuit').fadeOut(5000); 

        });
        
        errors = 'Cuit Invalido '; 
    } else {
        //Consulta CUIT de AFIP
        var uri = 'https://soa.afip.gob.ar/sr-padron/v2/persona/' + cuit;   
        $.ajax({
            url: uri,
            type: 'GET',
            success: function(res) {
                var datosAfip = res.data;
                $('#field-nombre_proveedor').val(datosAfip.nombre);
                $('#field-domicilio').val(datosAfip.domicilioFiscal.direccion);
                $('#field-codigo_postal').val(datosAfip.domicilioFiscal.codPostal);
            }
        });
    } 
} 

$('#search_text').keypress(function(e) {
    if (e.which == 13) {
        $('#crud_search').click();
    }
});

function isValidCPA(cpa){
    cpa = cpa.trim();
    if (cpa.match(/^([A-HJ-TP-Z]{1}\d{4}[A-Z]{3}|[a-z]{1}\d{4}[a-hj-tp-z]{3})$/)) {
        return true;
    } else {
        return false;
    }
}

$('#filtering-form-search').live('shown', function () {
    $('#search_text').focus();
}); 

$('#btn-agenda-contactos').click(function () {
    
    var _entidad = $(this).attr('data-entidad');
    var _campo = $(this).attr('data-campo');
    var _valor_id = $(this).attr('data-id');

    $('#entidad-field').val(_entidad);
    $('#campo-field').val(_campo);
    $('#valor_id-field').val(_valor_id);

    var uri = '/sistema/customer_controller/getContactos';
    if (window.location.host !== 'localhost') {
        uri = '/sistema/customer_controller/getContactos';
    }

    $.ajax({
        url: uri,
        data: {entidad: _entidad, campo: _campo, valor_id: _valor_id},
        type: 'POST',
        success: function(data) {
            
            $('#tabla-contactos').html(data);
            $('#modal-agenda-contactos').modal();
        }
    });   
    
});

$('#btn-agregar-contacto').click(function(){

    var _entidad = $('#entidad-field').val();
    var _campo = $('#campo-field').val();
    var _valor_id = $('#valor_id-field').val();

    var _nombre = $('#nombre-contacto').val();
    var _telefono = $('#telefono-contacto').val();
    var _email = $('#email-contacto').val();
    var _direccion = $('#direccion-contacto').val();

    var uri = '/sistema/customer_controller/addContacto';
    if (window.location.host !== 'localhost') {
        uri = '/sistema/customer_controller/addContacto';
    }

    $.ajax({
        url: uri,
        data: {entidad: _entidad, campo: _campo, valor_id: _valor_id, nombre: _nombre, telefono: _telefono, email: _email, direccion:_direccion},
        type: 'POST',
        success: function(err) {
           
           if (err == 1) {
               alert('Error al guardar contacto'); 
           } else {

                //Limpia controles
                $('#nombre-contacto').val('');
                $('#telefono-contacto').val('');
                $('#email-contacto').val('');
                $('#direccion-contacto').val('');
                
                //Obtiene los contactos
                var uriGet = '/sistema/customer_controller/getContactos';
                if (window.location.host !== 'localhost') {
                    uriGet = '/sistema/customer_controller/getContactos';
                }

                $.ajax({
                    url: uriGet,
                    data: {entidad: _entidad, campo: _campo, valor_id: _valor_id},
                    type: 'POST',
                    success: function(data) {
                         $('#tabla-contactos').html(data);   
                    }
                });

           }
        }
    });   

});

$('input[name="articulo_fenix"').blur(function() {
    //var uri = '/fenix/sistema/articulo_controller/buscarArticulo';
    uri = '/articulo_controller/buscarArticulo';
    if (window.location.host != 'localhost') {
        uri = '/sistema/articulo_controller/buscarArticulo';
    }

    var _codFenix = $(this).val();

    $.ajax({
        url: uri,
        data: {codfenix: _codFenix},
        type: 'POST',
        success: function(data) {
            var datosJson = JSON.parse(data);
            if (datosJson.err == 1) {
                $('#descripcion-art').html('');
          
                $('#msg-modal-error').html("Articulo inexistente");
                $('#modal-error').modal();
                
            } else {
                $('#descripcion-art').html(' ' + datosJson.descripcion);
            }

        }
    });
});

</script>