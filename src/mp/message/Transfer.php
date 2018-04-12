<?php

namespace tebie6\wx\mp\message;

use tebie6\wx\core\Driver;

class Transfer extends Driver {

    public $type = 'transfer_customer_service';
    public $props = [];
}