 <div class="modal hide fade" id="forma-pago-modal" style="width: 673px;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Formas de Pago</h3>
    </div>
    <div class="modal-body">

        <!-- TARJETA DE CREDITO -->
        <div class="row-fluid">
            <div class="span12" id="form-tarjeta-credito">
                <div class="widget red">
                    <div class="widget-title">
                        <h4><i class="icon-reorder"></i> Tarjeta de Crédito: Detalle del Pago</h4>
                        <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                        </span>
                    </div>
                    <div class="widget-body">
                        <div class="portlet-body">
                            <div class="row-fluid">
                                <div class="span12 billing-form">
                                    <div class="space12"></div>
                                    <form action="#">
                                        <div class="control-group ">
                                            <label class="control-label">Empresa</label>
                                            <select id="tc-empresa" class="chzn-select-deselect" data-placeholder="Seleccione empresa">
                                                <option value="1">Visa</option>
                                                <option value="2">Master Card</option>
                                                <option value="3">American Express</option>
                                                <option value="4">Naranja</option>
                                                <option value="5">Cordobesa</option>
                                             </select>
                                        </div>
                                        <div class="control-group ">
                                            <label class="control-label">Cant. Pagos</label>
                                             <select id="tc-cant-pagos" class="chzn-select-deselect" data-placeholder="Seleccione cantidad de pagos">
                                                <option value="1">1</option>
                                                <option value="3">3</option>
                                                <option value="6">6</option>
                                                <option value="12">12</option>
                                                <option value="18">18</option>
                                                <option value="z">Plan Z</option>
                                             </select>
                                        </div>
                                        <div class="control-group ">
                                            <label class="control-label">Titular</label>
                                            <input type="text" id="tc-titular" class="span8">
                                        </div>
                                        <div class="control-group ">
                                            <label class="control-label">DNI</label>
                                            <input type="text" id="tc-dni-titular" class="span5">
                                        </div>
                                        <div class="control-group ">
                                            <label class="control-label">Telefono</label>
                                            <input type="text" id="tc-telefono" class="span5">
                                        </div>

                                        <div class="control-group ">
                                            <label class="control-label">Nro Autorización</label>
                                            <input type="text" id="tc-nro-autorizacion" class="span5">
                                        </div>
                                    </form>
                                </div>
                            </div>               
                        </div>
                    </div>
                </div>
            </div>
        </div>  
        
        <!-- TARJETA DE DEBITO -->
        <div class="row-fluid">
            <div class="span12" id="form-tarjeta-debito">
                <div class="widget red">
                    <div class="widget-title">
                        <h4><i class="icon-reorder"></i> Tarjeta de Débito: Detalle del Pago</h4>
                        <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                        </span>
                    </div>
                    <div class="widget-body">
                        <div class="portlet-body">
                            <div class="row-fluid">
                                <div class="span12 billing-form">
                                    <div class="space12"></div>
                                    <form action="#">
                                        <div class="control-group ">
                                            <label class="control-label">Empresa</label>
                                            <select id="td-empresa" class="chzn-select-deselect" data-placeholder="Seleccione vehiculo">
                                                <option value="1">Visa</option>
                                                <option value="2">Master Card</option>
                                                <option value="3">American Express</option>
                                                <option value="4">Naranja</option>
                                                <option value="5">Cordobesa</option>
                                             </select>
                                        </div>
                                        <div class="control-group ">
                                            <label class="control-label">Titular</label>
                                            <input type="text" id="td-titular" class="span8">
                                        </div>
                                        <div class="control-group ">
                                            <label class="control-label">DNI</label>
                                            <input type="text" id="td-dni-titular" class="span5">
                                        </div>
                                        <div class="control-group ">
                                            <label class="control-label">Telefono</label>
                                            <input type="text" id="td-telefono" class="span5">
                                        </div>
                                          <div class="control-group ">
                                            <label class="control-label">Nro Autorización</label>
                                            <input type="text" id="td-nro-autorizacion" class="span5">
                                        </div>
                                    </form>
                                </div>
                            </div>               
                        </div>
                    </div>
                </div>
            </div>
        </div>  


        <!-- CHEQUE -->
        <div class="row-fluid">
            <div class="span12" id="form-cheque">
                <div class="widget red">
                    <div class="widget-title">
                        <h4><i class="icon-reorder"></i> Cheque: Detalle del Pago</h4>
                        <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                        </span>
                    </div>
                    <div class="widget-body">
                        <div class="portlet-body">
                            <div class="row-fluid">
                                <div class="span12 billing-form">
                                    <div class="space12"></div>
                                    <form action="#">
                                        <div class="control-group">
                                            <label class="control-label">Banco</label>
                                            <select id="cheque-banco" class="chzn-select-deselect" data-placeholder="Seleccione el banco" style="width:270px">
                                                 <?php
                                                foreach ($bancos as $key => $value) {
                                                 
                                                    echo '<option value="' . $value['id'] . '">' . $value['nombre'] . '</option>';
                                                }
                                                ?>
                                             </select>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Nro de Cheque</label>
                                            <input type="text" id="nro-cheque" class="span4">
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Fecha de Cobro</label>
                                            <input type="text" id="cheque-fecha-cobro" class="span4">
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Importe</label>
                                            <input type="text" id="importe-cheque" class="span4">
                                        </div>
                                    </form>
                                </div>
                            </div>               
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <button class="btn btn-primary btn-medium hidden-print" id="guardar-datos-tc">Guardar <i class="icon-save"></i></button>
        <button class="btn btn-primary btn-medium hidden-print" id="guardar-datos-td">Guardar <i class="icon-save"></i></button>
        <button class="btn btn-primary btn-medium hidden-print" id="guardar-datos-cheque">Guardar <i class="icon-save"></i></button>
    </div>
 </div>
<script type="text/javascript">
   
</script>