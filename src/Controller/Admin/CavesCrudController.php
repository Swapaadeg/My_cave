<?php

namespace App\Controller\Admin;

use App\Entity\Caves;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class CavesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Caves::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom', 'Nom de la cave'),
            TextEditorField::new('description'),
            AssociationField::new('cave', 'Propriétaire')->autocomplete(),
            TextField::new('imageName', 'Image')->onlyOnIndex(),
            DateTimeField::new('created_at', 'Créée le')->hideOnForm(),
            DateTimeField::new('updatedAt', 'Dernière modification')->hideOnForm(),
        ];
    }
}
