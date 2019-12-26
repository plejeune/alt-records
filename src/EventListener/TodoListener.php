<?php

namespace App\EventListener;

use App\Entity\Article;
use Doctrine\ORM\Event\LifecycleEventArgs;

class TodoListener {

    public function postPersist(LifecycleEventArgs $args) {

        $entity = $args->getObject();

        if(!$entity instanceof Article) {
            return;
        }

        echo $entity->getTitle();
    }
}