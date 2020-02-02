<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBookingController extends AbstractController
{
    /**
     * @Route("/admin/bookings", name="admin_booking_index")
     */
    public function index(BookingRepository $repo)
    {
       // $repo=$this->getDoctrine()->getRepository(Booking::class);
        //$booking=$repo->findAll();
        // $repo=$this->getDoctrine()->getRepository(Comment::class);
        //$comments=$repo->findAll();

        return $this->render('admin/booking/index.html.twig', [
            
            'bookings'=>$repo->findAll(),
            //'booking'=>$booking
           
        ]);
    }
}
