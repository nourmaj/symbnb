<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/login", name="account_login")
     */
    public function login(AuthenticationUtils $utils)
    {
        $error=$utils->getLastAuthenticationError();
        $username=$utils->getLastUsername();
        return $this->render('account/login.html.twig',[
            'hasError'=>$error !==null,
            'username'=>$username
        ]);
    }

    /**
     * @Route("/logout", name="account_logout")
     * 
     *
     * @return void
     */
    Public function logout(){
        //automatique
    }
    /**
     * @Route("/register", name="account_register")
     * 
     * @return Response 
     */

    public function register(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder){
        
        $user =new User();

        $form=$this->createForm(RegistrationType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){

            $hash=$encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre compte a été crée !"
            );

            return $this->redirectToRoute("account_login");
        }

    
        return $this->render('account/registration.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/account/profile", name="account_profile")
     * 
     * @IsGranted("ROLE_USER")
     * 
     * @return Response
     */


    public function profile(Request $request , ObjectManager $manager)
    {
        $user=$this->getUser();
        $form= $this->createForm(AccountType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid())
        {
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre compte a été modifié !"
            );

        }
        return $this->render('account/profile.html.twig' ,[

            'form'=>$form->createView()
            
        ]);
        
    }

    /**
     * Permet de moddifier le mot de passe
     * 
     * @Route("/account/update-password", name="account_password")
     * @isGranted("ROLE_USER")
     */

    public function updatePassword(Request $request,ObjectManager $manager , UserPasswordEncoderInterface $encoder)
    {

        $passwordUpdate= new PasswordUpdate();
        $user=$this->getUser();
        $form=$this->createForm(PasswordUpdateType::class, $passwordUpdate);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            //1.verifier que le old password identique ou non
            if(!password_verify($passwordUpdate->getOldpassword(), $user->getHash()))
            //gerer l'erreur ssi n'est pas vrai 
            {
                $form->get('oldPassword')->addError(new FormError("le mot de passe que vous avez tapé n'est pas votre mot de passe actuel !"));
            }
            else{
                $newPassword=$passwordUpdate->getNewPassword();
                $hash=$encoder->encodePassword($user, $newPassword);
                $user->setHash($hash);
                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "Votre mot de passe a été modifié"
                );
                return $this->redirectToRoute('homepage');

            }

          
          
        }

          

        

        return $this->render('account/password.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * afficher compte utitlsateur 
     * 
     * @Route("/account", name="account_index")
     * @isGranted("ROLE_USER")
     */

    public function myAccount()
    {

            return $this->render('user/index.html.twig' ,[
                'user'=>$this->getUser()

                ]);

    }
}
