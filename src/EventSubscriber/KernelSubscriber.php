<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelSubscriber implements EventSubscriberInterface {

    public static function getSubscribedEvents() {

        return [
            KernelEvents::EXCEPTION => [
                ['showErrorMessage' , 10]
            ]
        ];

    }

    public function showErrorMessage() {
        dump('Something wrong happened');
    }
}