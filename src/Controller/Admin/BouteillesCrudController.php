<?php
namespace App\Controller\Admin;

use App\Entity\Bouteilles;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class BouteillesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bouteilles::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            IntegerField::new('millesime'),
            AssociationField::new('cepage'),
            AssociationField::new('type'),
            AssociationField::new('pays'),
            AssociationField::new('region'),
            TextareaField::new('description'),
            ImageField::new('image_name')
                ->setBasePath('uploads/images/')
                ->setUploadDir('public/uploads/images/')
                ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                ->setRequired(false),
            DateTimeField::new('updated_at')->hideOnForm(),
        ];
    }
}