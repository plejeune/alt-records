<?php

namespace App\EventListener;

class KernelException {

    public function onKernelException() {
        die('I am a listener');
    }
}