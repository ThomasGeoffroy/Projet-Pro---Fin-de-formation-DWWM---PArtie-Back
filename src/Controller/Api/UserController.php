<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/api/inscription",name="app_api_user_add", methods={"POST"})
     */
    public function add(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher ): Response
    {
        // Creation of a new User object
        $user = new User();
    
        // Receiving data from the front and put it into string
        $userJ = json_decode($request->getContent(), true);

        // Setting all of the User properties with the received data
        $user->setFirstname($userJ["firstname"]);
        $user->setLastname($userJ["lastname"]);
        $user->setEmail($userJ["email"]);
        $user->setPhoneNumber($userJ["phonenumber"]);
        $user->setAddress($userJ["address1"]);
        $user->setAddressDetails($userJ["address2"]);
        $user->setCity($userJ["city"]);
        $user->setZipcode($userJ["zipcode"]);
        $user->setCountry($userJ["country"]);

        // Setting automatically the status to 1 as "active" for each new User
        $user->setStatus(1);

        // retrieves the non-hashed password filled in the form
        $password = $userJ["password"];


        // hash the password (based on the security.yaml config for the $user class)
        // $user retrieves the corresponding hash logic in the security.yaml
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $password,
        );
        // Sets the hashed password
        $user->setPassword($hashedPassword);

        // the "CreatedAt" property is filled with the time & date of the creation automatically
        $user->setCreatedAt(new DateTimeImmutable());

        // the new object is added to the database
        $userRepository->add($user, true);

        // Returning the new created User
        return $this->json($user,Response::HTTP_OK);
    }

}
