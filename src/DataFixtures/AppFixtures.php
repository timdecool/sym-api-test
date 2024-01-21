<?php

namespace App\DataFixtures;

use App\Entity\Availability;
use App\Entity\Group;
use App\Entity\Profile;
use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $users = [
            [
                'firstName' => 'Michel',
                'lastName' => 'Boulon',
                'email' => 'michel.boulon@laposte.net',
                'password' => 'coucou',
                'availabilities' => [
                    [
                        'beginAt' => '2024-01-21 16:00:00',
                        'endAt' => '2024-01-21 19:00:00'
                    ]
                ]
            ],
            [
                'firstName' => 'Miranda',
                'lastName' => 'Portique',
                'email' => 'mirandaportique@yahoo.fr',
                'password' => 'coucou',
                'availabilities' => [
                    [
                        'beginAt' => '2024-01-21 13:00:00',
                        'endAt' => '2024-01-21 17:00:00'
                    ]
                ]
            ],            
            [
                'firstName' => 'Martin',
                'lastName' => 'Matin',
                'email' => 'martin.matin@cegetel.net',
                'password' => 'coucou',
                'availabilities' => [
                    [
                        'beginAt' => '2024-01-21 11:00:00',
                        'endAt' => '2024-01-21 15:00:00'
                    ]
                ]
            ]
        ];
        
        $group = new Group;
        $group
            ->setName('Les zozos du dojo')
            ->setCreatedAt(new DateTimeImmutable('now', new DateTimeZone('Europe/Paris')))
        ;

        foreach($users as $u) {
            $user = new User;
            $user
                ->setEmail($u['email'])
                ->setPassword($u['password'])
            ;

            foreach($u['availabilities'] as $av) {
                $availability = new Availability;
                $availability
                    ->setBeginAt(new DateTime($av['beginAt']))
                    ->setEndAt(new DateTime($av['endAt']))
                    ->setUser($user)
                    ->addRelatedGroup($group)
                ;
                $manager->persist($availability);
            }

            $profile = new Profile;
            $profile
                ->setFirstName($u['firstName'])
                ->setLastName($u['lastName'])
                ->setUser($user)
            ;

            $group->addUser($user);
            if($u['firstName'] === 'Miranda') {
                $group->setCreator($user);
            }
            
            $manager->persist($user);
            $manager->persist($profile);
        }

        $manager->persist($group);
        
        $manager->flush();
    }
}
