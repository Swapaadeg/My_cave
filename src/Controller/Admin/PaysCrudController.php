<?php

namespace App\Controller\Admin;

use App\Entity\Pays;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PaysCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Pays::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),

        ];
    }
    
}
