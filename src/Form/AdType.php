<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdType extends AbstractType
{
    
    private function getConfiguration($label ,$placeholder,$options=[]){

        return array_merge([
            'label'=>$label,
        'attr' => [
            'placeholder'=>$placeholder,
        ]

        ], $options);

    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('title' , TextType::class ,[
                'label'=>'Titre',
                'attr' => [
                    'placeholder'=>"Taper un titre pour l'annonce !"
                ]
            ])
            ->add('slug' , TextType::class , [
                'label'=>'Slug',
                'attr'=>[
                    'placeholder'=>"adresse web (automatique)"
                ]
            ])
            */
            ->add(
                'title',
                TextType::Class ,
                $this->getConfiguration('Titre','Tapez un super titre')
                )
            ->add(
                'slug',
                TextType::class,
                $this->getConfiguration('Adresse web',"Tapez l'adresse web(automatique)",[
                    'required'=>false
                ])
                )
            ->add(
                'coverImage',
                UrlType::class,
                $this->getConfiguration("Url de l'image principale",'Adresse SVP')
                )
            ->add(
                'introduction',
                 TextType::class,
                 $this->getConfiguration('Introduction',"donnez une descrption de l'annonce")
                )
            ->add(
                'content',
                TextareaType::class, 
                $this->getConfiguration('Description','Tapez une description qui donne envie de venir chez vous')
                )
            ->add(
                'rooms',
                IntegerType::class,
                $this->getConfiguration('Nombre de chmbre','le nombre de chambre dispo ')
                )
            ->add(
                'price',
                MoneyType::class,
                $this->getConfiguration('Prix','Indiquez le prix que voulez par une nuit')
                )
            ->add(
                'images',
                CollectionType::class, 
                [
                    'entry_type'=>ImageType::class,
                    'allow_add'=>true,
                    'allow_delete'=>true
                     
                ]
                ) ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}