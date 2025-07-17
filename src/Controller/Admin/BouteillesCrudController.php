<?php

namespace App\Controller\Admin;

use App\Entity\Bouteilles;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BouteillesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bouteilles::class;
    }
}
