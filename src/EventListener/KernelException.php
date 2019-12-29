<?php

namespace App\EventListener;

class KernelException {

    public function onKernelException() {
        die('Something went wrong.');
    }
}