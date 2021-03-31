
    $(document).ready(function () {

        $(document).ajaxSend(function (e, jqXHR) {
            //show the loading div here
            $('#modal-procesando').modal();
        });

        $(document).ajaxComplete(function (e, jqXHR) {
            //remove the div here
            $('#modal-procesando').modal('hide');
        });

        $(document).ajaxError(function (event, jqxhr, settings, thrownError) {

            $('#msg-modal-error').html('<textarea rows="5" style="width:390px" readonly>Llamada: ' + settings.url + '.\n\rCódigo: ' + jqxhr.status + ' Descripción: ' + jqxhr.statusText + '</textarea>');
            $('#modal-error').modal();

        });
        
    });
