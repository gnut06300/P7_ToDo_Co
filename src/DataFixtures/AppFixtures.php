<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher )
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $task = new Task();

        $user->setUsername("admin")
            ->setEmail("admin@admin.fr")
            ->setRoles(["ROLE_ADMIN"])
            ->setPassword($this->passwordHasher->hashPassword($user, 'password'))
            ->setIsVerified(1);
        $manager->persist($user);
        
        $task->setAuthor(null)
            ->setTitle("Titre de la tâche")
            ->setContent("Contenu de la tâche.")
            ->setIsDone(0)
            ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($task);

        for ($i=1; $i <=3 ; $i++) { 
            $user1 = new User();

            $user1->setUsername("user$i")
                ->setEmail("user$i@gnut.eu")
                ->setPassword($this->passwordHasher->hashPassword($user1, 'password'))
                ->setIsVerified(1);
            $manager->persist($user1);

            for ($j=1; $j <=3; $j++) { 
                $task1 = new Task();

                $task1->setTitle("A faire $i-$j")
                    ->setContent("Description $i-$j : Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris nisl nulla, pretium quis mattis vel, feugiat eget metus. Vestibulum a.")
                    ->setIsDone(0)
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setAuthor($user1);
                $manager->persist($task1);
            }
                
        }

        $manager->flush();
    }
}
