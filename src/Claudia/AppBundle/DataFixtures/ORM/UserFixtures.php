<?php

namespace Claudia\AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Atiss\Bundle\CoreBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserFixtures extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $em)
    {
        /** @var \Faker\Generator $generator */
        $generator = $this->container->get('faker.generator');

        $user = new User();
        $user->setFirstName('Admin');
        $user->setEmail('admin@scrumlite.local');
        $user->setUsername('admin');
        $user->setPlainPassword('admin');
        $user->setRoles(array('ROLE_ADMIN'));
        $user->setEnabled(true);
        $file = new File(sprintf("%s/../../Resources/fixtures/user/avatar/%s.jpg", dirname(__FILE__), rand(1, 157)));
        $uploadedFile = new UploadedFile(
            $file->getPathname(),
            $file->getFilename(),
            $file->getMimeType(),
            $file->getSize()
        );
        $user->setAvatar($uploadedFile);
        $em->persist($user);
        $this->addReference('user-admin', $user);

        $user = new User();
        $user->setFirstName('Jefe1');
        $user->setEmail('jefe1@scrumlite.local');
        $user->setUsername('jefe1');
        $user->setPlainPassword('jefe1');
        $user->setRoles(array('ROLE_BOSS'));
        $user->setEnabled(true);
        $file = new File(sprintf("%s/../../Resources/fixtures/user/avatar/%s.jpg", dirname(__FILE__), rand(1, 157)));
        $uploadedFile = new UploadedFile(
            $file->getPathname(),
            $file->getFilename(),
            $file->getMimeType(),
            $file->getSize()
        );
        $user->setAvatar($uploadedFile);
        $em->persist($user);
        $this->addReference('user-jefe1', $user);

        $user = new User();
        $user->setFirstName('Trabajador1');
        $user->setEmail('trabajador1@scrumlite.local');
        $user->setUsername('trabajador1');
        $user->setPlainPassword('trabajador1');
        $user->setEnabled(true);
        $file = new File(sprintf("%s/../../Resources/fixtures/user/avatar/%s.jpg", dirname(__FILE__), rand(1, 157)));
        $uploadedFile = new UploadedFile(
            $file->getPathname(),
            $file->getFilename(),
            $file->getMimeType(),
            $file->getSize()
        );
        $user->setAvatar($uploadedFile);
        $em->persist($user);
        $this->addReference('user-trabajador1', $user);

        for ($i = 1; $i <= 100; $i++) {
            $user = new User();
            $user->setFirstName($generator->firstName);
            $user->setEmail($generator->email);
            $user->setUsername($generator->userName);

            $file = new File(sprintf("%s/../../Resources/fixtures/user/avatar/%s.jpg", dirname(__FILE__), rand(1, 157)));
            $uploadedFile = new UploadedFile(
                $file->getPathname(),
                $file->getFilename(),
                $file->getMimeType(),
                $file->getSize()
            );
            $user->setAvatar($uploadedFile);

            $user->setPlainPassword($generator->word);
            $user->setEnabled(true);

            $em->persist($user);
            $this->addReference(sprintf('user-%s', $i), $user);
        }

        $em->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}