<ul class="breadcrumb">
    <?php
        $badBredcrum = array(
            'success' => ''
        );
        $breadcrumbLevel = $this->uri->segment_array();
        $j = 1;
        foreach ($breadcrumbLevel as $breadcrumbUri) {
            if (!array_key_exists($breadcrumbUri, $badBredcrum) && !is_numeric($breadcrumbUri)) {
            ?><li>
                <?php 
                    if ($breadcrumbUri == 'add') {
                        $breadcrumbUri = 'agregar';
                    } else if ($breadcrumbUri == 'success') {
                        $breadcrumbUri = 'éxito';
                    } else if ($breadcrumbUri == 'read') {
                        $breadcrumbUri = 'visualizacion';
                    }
                ?>
                <?php echo $breadcrumbUri ?>
                <span class="divider">/</span>
            </li>
       <?php
            }
       $j ++;
       }
    ?>
</ul>