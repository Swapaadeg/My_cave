<?php
namespace App\Controller\Admin;

use App\Entity\Bouteilles;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

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
            TextField::new('cepage'),
            TextField::new('type'),
            TextField::new('pays'),
            TextField::new('region'),
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