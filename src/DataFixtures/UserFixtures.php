<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $password_encoder)
    {
        $this->password_encoder = $password_encoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach($this->getUserData() as [$name, $last_name, $email, $password, $api_key, $roles]) 
        {
            $user = new User();
            $user->setName($name);
            $user->setLastName($last_name);
            $user->setEmail($email);
            $user->setPassword($this->password_encoder->encodePassword($user, $password));
            $user->setVimeoApiKey($api_key);
            $user->setRoles($roles);
            $manager->persist($user);

        }

        $manager->flush();
    }

    private function getUserData(): array {
        return [
            ["Sushil", "Parajuli", "sushilparajuli@email.com", "password", "123456", ['ROLE_ADMIN']],
            ["Sushil", "Parajuli1", "sushiladmin2@email.com", "password", "123456", ['ROLE_ADMIN']],
            ["Sushil", "User", "sushiluser@email.com", "password", "123456", ['ROLE_USER']]
        ];
    }
}
