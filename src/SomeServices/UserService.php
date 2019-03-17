<?php

namespace App\SomeServices;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return User
     */
    public function register(string $email, string $password): User
    {
        $user = (new User())->setEmail($email);
        $user->setPassword($this->userPasswordEncoder->encodePassword($user, $password));

        $this->userRepository->storeUser($user);

        return $user;
    }
}