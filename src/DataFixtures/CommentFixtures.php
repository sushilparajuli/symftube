<?php

namespace App\DataFixtures;



use App\Entity\Comment;
use App\Entity\Video;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\UserFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->CommentData() as [$content, $user, $video, $created_at]) {
            $comment = new Comment;
            $user = $manager->getRepository(User::class)->find($user);
            $video = $manager->getRepository(Video::class)->find($video);
            $comment->setContent($content);
            $comment->setUser($user);
            $comment->setVideo($video);
            $comment->setCreatedAtForFixtures(new \DateTime($created_at));

            $manager->persist($comment);

        }


        $manager->flush();
    }
    
    private function CommentData()
    {
        return [
            ['Lorem ipsum dolor sit, amet consectetur adipisicing elit. Delectus ea eius ad aperiam maxime, qui, velit illo accusamus natus vero ullam autem quo ut placeat libero sed repellat harum nobis!',
            1,10,'2018-10-08 12:34:45'],
            ['Lorem ipsum dolor sit, amet consectetur adipisicing elit. Delectus ea eius ad aperiam maxime, qui, velit illo accusamus natus vero ullam autem quo ut placeat libero sed repellat harum nobis!',
                2, 10, '2018-10-08 12:34:45'],
            ['Lorem ipsum dolor sit, amet consectetur adipisicing elit. Delectus ea eius ad aperiam maxime, qui, velit illo accusamus natus vero ullam autem quo ut placeat libero sed repellat harum nobis!',3, 10, '2018-10-08 12:34:45']
        ];
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class
        );
    }
}
