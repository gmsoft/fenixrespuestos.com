<div class="span7">
    <div class="widget green">
        <div class="widget-title">
            <h4><i class="icon-reorder"></i> Buscar por </h4>
            <span class="tools">
                <a href="javascript:;" class="icon-chevron-down"></a>                                
            </span>
        </div>
        <div class="widget-body">
            <form method="post" action="listavw" id="form_consulta">
                <div class="row-fluid">
                    <div class="span5">
                        <div class="control-group">
                            <div class="controls controls-row">
                                <input type="text" class="input-block-level" placeholder="OEM (Ejemplo: 028-260-299-2)" name="original" value="<?php echo isset($oem)?$oem:'';?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span10">
                        <div class="control-group">
                            <div class="controls controls-row">
                                <input type="text" class="input-block-level" placeholder="Descripcion" name="descripcion" value="<?php echo isset($descripcion)?$descripcion:'';?>">
                            </div>
                        </div>
                    </div>
                </div>                                
            </form>
        </div>
    </div>
</div>