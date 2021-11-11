<?php

namespace Invoice\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class ItemRepository extends EntityRepository implements ItemRepositoryInterface
{
    public function __construct(EntityManager $em, ClassMetadata $class)
    {
        parent::__construct($em, $class, 'item');
    }
}
