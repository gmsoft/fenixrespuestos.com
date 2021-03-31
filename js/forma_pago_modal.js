var formaPagoTarjetaCredito = [];
var formaPagoTarjetaDebito = [];
var formaPagoCheque = [];

$('#cond-venta').change(function() {
    selectCondVenta();
});

function selectCondVenta() {
    var cod_cond_vta = $('#cond-venta :selected').attr('data-codigo');

    if (cod_cond_vta === 'CREDITO'
        || cod_cond_vta === 'DEBITO'
        || cod_cond_vta === 'CHEQUE') {

        $('#form-tarjeta-credito').hide();
        $('#form-tarjeta-debito').hide();
        $('#form-cheque').hide();
        $('#guardar-datos-cheque').hide();
        $('#guardar-datos-tc').hide();
        $('#guardar-datos-td').hide();

        if (cod_cond_vta === 'CREDITO' ) {
            $('#guardar-datos-tc').show();
            $('#form-tarjeta-credito').show();
        }

        if (cod_cond_vta === 'DEBITO') {
            $('#guardar-datos-td').show();
            $('#form-tarjeta-debito').show();
        }

        if (cod_cond_vta === 'CHEQUE') {
            $('#guardar-datos-cheque').show();
            $('#form-cheque').show();
        }

        $('#forma-pago-modal').modal();                    

    }
}
        
var nowTemp = new Date();
var now = new Date(nowTemp.getDate(), nowTemp.getMonth(), nowTemp.getFullYear(), 0, 0, 0, 0);

var checkin = $('#cheque-fecha-cobro').datepicker({
    format: 'dd/mm/yyyy', 
    minDate:0,
    onRender: function(date) {
        return date.valueOf() < now.valueOf() ? 'disabled' : '';
      }
    }).on('changeDate', function(ev) {
      console.log(ev.date.valueOf());
      if (ev.date.valueOf() < nowTemp.valueOf()) {
        alert('La fecha de cobro debe ser superior al día de hoy');
      } else {
        checkin.hide();  
      }                  
    }).data('datepicker');

 //GUARDA DATOS TARJETA DE CREDITO       
$('#guardar-datos-tc').click(function() {                
    formaPagoTarjetaCredito = [];

    var datosTarjeta = {
          empresa: $('#tc-empresa').val(),
          plan_pago: $('#tc-cant-pagos').val(),
          titular: $('#tc-titular').val(),
          dni: $('#tc-dni-titular').val(),
          telefono: $('#tc-telefono').val(),
          codigo_autorizacion: $('#tc-nro-autorizacion').val()
    };

    formaPagoTarjetaCredito.push(datosTarjeta);

    $('#forma-pago-modal').modal('hide');
});

//GUARDA DATOS TARJETA DE DEBITO       
$('#guardar-datos-td').click(function() {                
    formaPagoTarjetaDebito = [];

    var datosTarjeta = {
          empresa: $('#td-empresa').val(),
          titular: $('#td-titular').val(),
          dni: $('#td-dni-titular').val(),
          telefono: $('#td-telefono').val(),
          codigo_autorizacion: $('#td-nro-autorizacion').val()
    };

    formaPagoTarjetaDebito.push(datosTarjeta);

    console.log(formaPagoTarjetaDebito);

    $('#forma-pago-modal').modal('hide');
});

 //GUARDA DATOS CHEQUE
$('#guardar-datos-cheque').click(function() {                
    formaPagoCheque = [];

    var datosCheque = {
          banco: $('#cheque-banco').val(),
          nroCheque: $('#nro-cheque').val(),
          fechaCobro: $('#cheque-fecha-cobro').val(),
          importe: $('#importe-cheque').val()
    };

    formaPagoCheque.push(datosCheque);

    $('#forma-pago-modal').modal('hide');
});