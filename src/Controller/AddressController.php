<?php

namespace App\Controller;

use App\Entity\Address;
use App\Repository\AddressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AddressController extends AbstractController
{
    private AddressRepository $addressRepository;

    public function __construct(AddressRepository $addressRepository) {
       $this->addressRepository = $addressRepository;
    }

    #[Route('/address', name: 'address.indexall', methods: ['GET', 'HEAD'])]
    public function indexall(): Response
    {
	$addresses = $this->addressRepository->findAll();
	//dd($addresses);    // debug
        return $this->render('address/indexall.html.twig', [
            'addresses' => $addresses,
        ]);
    }

    #[Route('/address/{id}', name: 'address.show', methods: ['GET', 'POST'])]
    public function show(int $id): Response
    {
	$address = $this->addressRepository->findOneById($id);
        return $this->render('address/show.html.twig', [
            'address' => $address,
	]);
    }

}
