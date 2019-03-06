<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationType extends ApplicationType
{

    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',
            TextType::class,
            $this->getConfiguration('prénom','Votre prénom svp'))
            ->add('lastName',
            TextType::class,
            $this->getConfiguration('Nom','Votre Nom Svp'))
            ->add('email',
            EmailType::class,
            $this->getConfiguration('Votre email',"votre adresse email"))
            ->add('picture',
            UrlType::class,
            $this->getConfiguration("Photo de profil","Url de photo")
            )
            ->add('hash',
            PasswordType::class,
            $this->getConfiguration("Mot de passe","Choisissez un bon mot de passe")
            )
            ->add('passwordConfirm',
            PasswordType::class,
            $this->getConfiguration("Confirmation de Mot de passe","Confirmez votre mot de passe ")
            )
            ->add('introduction',
            TextType::class,
            $this->getConfiguration('Introduction','présentez vous ..'))
            ->add('description',
            TextareaType::class,
            $this->getConfiguration("Description détaillée","présentez en détaille"))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
