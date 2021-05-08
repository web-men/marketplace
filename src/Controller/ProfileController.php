<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Shop;
use App\Entity\User;
use App\Form\AddAddressFormType;
use App\Form\AddShopFormType;
use App\Form\CategoryFormType;
use App\Form\ProductFormType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProfileController extends AbstractController
{
    private const FLASH_INFO = 'info';

    #[Route('/user/profile', name: '_profile')]
    public function profile(): Response
    {
        return $this->render('profile/profile.html.twig', ['user' => $this->getUser()]);
    }

    #[Route('/user/listShops', name: '_profile_listShops')]
    public function listShops(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->render('profile/listShops.html.twig', ['shops' => $user->getShops()]);
    }

    #[Route('/user/viewShop/{id<\d+>}', name: '_profile_viewShop')]
    public function viewShop(Shop $shop, ProductRepository $productRepository, Request $request): Response
    {
        $page = $request->get('page', 1);

        return $this->render('profile/viewShop.html.twig', [
            'shop' => $shop,
            'products' => $productRepository->getListByShop($shop, $page),
        ]);
    }

    #[Route('/user/deleteShop/{id<\d+>}', name: '_profile_deleteShop')]
    public function deleteShop(Shop $shop, EntityManagerInterface $em): Response
    {
        $em->remove($shop);
        $em->flush();

        return $this->redirectToRoute('_profile');
    }

    #[Route('/user/editShop/{id<\d+>}', name: '_profile_editShop')]
    public function editShop(Request $request, Shop $shop, EntityManagerInterface $em, TranslatorInterface $t): Response
    {
        $form = $this->createForm(AddShopFormType::class, $shop);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($user instanceof User && $form->isSubmitted() && $form->isValid()) {
            $shop->addUser($user);
            $shop->setStatus($shop::STATUS_NEW);
            $em->persist($shop);
            $em->flush();

            $this->addFlash(self::FLASH_INFO, $t->trans('shop.added'));
            return $this->redirectToRoute('_profile');
        }

        return $this->render('profile/form.html.twig',
            [
                'contentTitle' => $t->trans('shop.add'),
                'form' => $form->createView(),
            ]
        );
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

            $this->addFlash(self::FLASH_INFO, $t->trans('shop.added'));
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

            $this->addFlash(self::FLASH_INFO, $t->trans('address.added'));
            return $this->redirectToRoute('_profile');
        }

        return $this->render('profile/form.html.twig',
            [
                'contentTitle' => $t->trans('address.add'),
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/user/addCategory', name: '_profile_addCategory')]
    public function addCategory(Request $request, EntityManagerInterface $em, TranslatorInterface $t): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryFormType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();

            $this->addFlash(self::FLASH_INFO, $t->trans('category.added'));
            return $this->redirectToRoute('_profile');
        }

        return $this->render('profile/form.html.twig',
            [
                'contentTitle' => $t->trans('category.add'),
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/user/addProduct/{shopId<\d+>}', name: '_profile_addProduct')]
    public function addProduct(Request $request, EntityManagerInterface $em, TranslatorInterface $t, int $shopId): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductFormType::class, $product);

        $form->handleRequest($request);

        $shop = $em->find(Shop::class, $shopId);
        if ($shop instanceof Shop && $form->isSubmitted() && $form->isValid()) {
            $product->setShop($shop);
            $em->persist($product);
            $em->flush();

            $this->addFlash(self::FLASH_INFO, $t->trans('product.added'));
            return $this->redirectToRoute('_profile_viewShop', ['id' => $shopId]);
        }

        return $this->render('profile/form.html.twig',
            [
                'contentTitle' => $t->trans('product.add'),
                'form' => $form->createView(),
            ]
        );
    }
}
