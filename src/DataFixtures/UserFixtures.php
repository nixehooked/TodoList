<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function encodePassword($user, $plainPassword): string
    {
        return $this->passwordEncoder->encodePassword($user, $plainPassword);
    }

    public function load(ObjectManager $manager)
    {
        // Admin
        $user = new User;

        $plainPassword = 'root';

        $newPassword = $this->encodePassword($user, $plainPassword);

        $user->setUsername('admin');
        $user->setEmail('admin@admin.fr');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($newPassword);

        $this->addReference('user-1', $user);

        $manager->persist($user);

        // User
        $user = new User;

        $plainPassword = 'root';

        $newPassword = $this->encodePassword($user, $plainPassword);

        $user->setEmail('user@user.fr');
        $user->setUsername('user');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($newPassword);

        $this->addReference('user-2', $user);

        $manager->persist($user);

        // Anonymous user
        $user = new User;

        $plainPassword = 'root';

        $newPassword = $this->encodePassword($user, $plainPassword);

        $user->setEmail('anonymous@anonymous.fr');
        $user->setUsername('anonymous');
        $user->setRoles(['ROLE_ANONYMOUS']);
        $user->setPassword($newPassword);

        $this->addReference('user-3', $user);

        $manager->persist($user);

    }
}