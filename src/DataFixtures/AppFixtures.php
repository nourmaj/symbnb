<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder=$encoder;
    }
    public function load(ObjectManager $manager )
    {
        
        $faker=Factory::create('fr-FR');

        //Nous gérons les users 
        $users=[];
        $genres=['male', 'femalle'];
        for($i= 1 ;$i<=10 ; $i++){

            $user=new User();
            $genre=$faker->randomElement($genres);
            
            
            $picture='https://randomuser.me/api/portraits/';
            $pictureId=$faker->numberBetween(1, 99) . '.jpg';

           /* if ($genre=="male") $picture=$picture . 'men/' .$pictureId; autre method
            else  $picture=$picture . 'women/' . $pictureId; 
            */
            $picture=$picture .($genre=='male' ? 'men/' : 'women/' ). $pictureId;

            $hash=$this->encoder->encodePassword($user, 'password');
            $user->setFirstName($faker->firstname($genres))
                 ->setLastName($faker->lastname($genres))
                 ->setEmail($faker->email)
                 ->setIntroduction($faker->sentence())
                 ->setDescription('<p>'.join('</p><p>',$faker->paragraphs(3)) .'</p>')
                 ->setHash($hash)
                 ->setPicture($picture);

            $manager->persist($user);
            $users[]=$user;

        }
        
       

        //nous geron les annonces
        
        for ($i=1; $i<=30 ; $i++)
        {
                $ad= new Ad();
                $title=$faker->sentence();
                
                $CoverImage=$faker->imageUrl(1000,350);
                $introduction=$faker->paragraph(2);
                $content='<p>'.join('</p><p>',$faker->paragraphs(5)) .'</p>';

                $user=$users[mt_rand(0,count($users)-1)];

                $ad->setTitle($title)
                
                     ->setCoverImage($CoverImage)
                ->setIntroduction($introduction)
                ->setContent($content) 
                ->setPrice(mt_rand(40, 200))
                ->setRooms(mt_rand(1, 5))
                ->setAuthor($user);
                
                for ($j =1; $j <= mt_rand(2, 5); $j++)
                    {
                    $image=new Image();

                    $image->setUrl($faker->imageUrl())
                          ->setCaption($faker->sentence())
                          ->setAd($ad);
                        $manager->persist($image);
                    }
                
                $manager->persist($ad);
        }
        
        $manager->flush();
    }
}
