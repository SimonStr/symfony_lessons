<?php


namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Post;
use AppBundle\Entity\Tag;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('Artem');
        $user->setPlainPassword('Artempass');

        $manager->persist($user);
        $manager->flush();
    }
}