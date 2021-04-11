<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Shop;
use App\Entity\User;
use App\Form\AddAddressFormType;
use App\Form\AddShopFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProfileController extends AbstractController
{
    #[Route('/user/profile', name: '_profile')]
    public function profile(): Response
    {
        return $this->render('profile/profile.html.twig', ['user' => $this->getUser()]);
    }

    #[Route('/user/addShop', name: '_profile_addShop')]
    public function addShop(Request $request, EntityManagerInterface $em, TranslatorInterface $t): Response
    {
        $shop = new Shop();
        $form = $this->createForm(AddShopFormType::class, $shop);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($user instanceof User && $form->isSubmitted() && $form->isValid()) {
            $shop->addUser($user);
            $shop->setStatus($shop::STATUS_NEW);
            $em->persist($shop);
            $em->flush();

            return $this->redirectToRoute('_profile');
        }

        return $this->render('profile/form.html.twig',
            [
                'contentTitle' => $t->trans('shop.add'),
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/user/addAddress', name: '_profile_addAddress')]
    public function addAddress(Request $request, EntityManagerInterface $em, TranslatorInterface $t): Response
    {
        $address = new Address();
        $form = $this->createForm(AddAddressFormType::class, $address);

        $form->handleRequest($request);
        $user = $this->getUser();

        if ($user instanceof User && $form->isSubmitted() && $form->isValid()) {
            $address->addUser($user);
            $em->persist($address);
            $em->flush();

            return $this->redirectToRoute('_profile');
        }

        return $this->render('profile/form.html.twig',
            [
                'contentTitle' => $t->trans('address.add'),
                'form' => $form->createView(),
            ]
        );
    }
}
