ALTER TABLE `fenix_base`.`comprobantes`   
  CHANGE `doc_nro` `doc_nro` BIGINT(30) NULL,
  CHANGE `concepto` `concepto` INT(1) DEFAULT 1  NULL  COMMENT '1:Productos, 2:Servicios, 3:Productos y Servicios';
