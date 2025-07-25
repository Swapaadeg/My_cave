<?php

namespace App\Controller\Admin;

use App\Entity\CommentairesCaves;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class CommentairesCavesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CommentairesCaves::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextEditorField::new('commentaire'),
            AssociationField::new('user', 'Auteur')->autocomplete(),
            AssociationField::new('cave', 'Cave')->autocomplete(),
            AssociationField::new('reponse', 'Répond à')->hideOnIndex(),
            DateTimeField::new('createdAt', 'Posté le')->hideOnForm(),
        ];
    }
}


