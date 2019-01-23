<?php
class Pf_Deactivator {
    function __construct() {
        $this->deactivate();
    }
    function deactivate() {
        update_option('pf_status', "deactive");
    }
}
