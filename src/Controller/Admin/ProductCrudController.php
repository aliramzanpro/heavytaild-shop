<?php

namespace App\Controller\Admin;


use App\Entity\Product;
use App\Form\PictureType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnform(),
            TextField::new('title'),
            SlugField::new('slug')
            ->setTargetFieldName('title')
            ->hideONIndex(),           
            TextEditorField::new('description','Description')->hideONIndex(),
            TextEditorField::new('details')->hideONIndex(),
            MoneyField::new('price')->setCurrency('USD'),
            IntegerField::new('quantity'),
            TextField::new('tags')->hideOnIndex(),
            BooleanField::new('isBestSeller', 'Best Seller'),
            BooleanField::new('isNewArrival', 'New Arrival'),
            BooleanField::new('isFeatured', 'Featured'),
            BooleanField::new('isSpecialOffer','Special Offer'),
            AssociationField::new('category', 'Category'),
            CollectionField::new('pictures', 'Picture')
            ->setEntryType(PictureType::class)
            ->setTemplatePath('admin/productPicture.html.twig')
            
        ];
    }
    
}
