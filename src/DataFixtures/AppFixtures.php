<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\User;
use App\Entity\VlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var Factory
     */
    private $faker;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = Factory::create();
    }
    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
        $this->loadVlogPosts($manager);
        $this->loadComments($manager);
    }
    public function loadVlogPosts(ObjectManager $manager): void
    {
        for ($i = 0; $i < 50; $i++) {
            $vlogPost = new VlogPost();
            $vlogPost->setTitle($this->faker->sentence());
            $vlogPost->setPublished($this->faker->dateTimeThisYear);
            $vlogPost->setContent($this->faker->paragraph());
            $vlogPost->setAuthor($this->getReference('user_admin'));
            $vlogPost->setSlug($this->faker->slug());

            $this->setReference("vlog_post_$i", $vlogPost);

            $manager->persist($vlogPost);
        }
        $manager->flush();
    }
    public function loadComments(ObjectManager $manager): void
    {
        for ($i = 0; $i < 25; $i++) {
            for ($j = 0; $j < rand(1, 4); $j++) {
                $comment = new Comment();
                $comment->setContent($this->faker->paragraph());
                $comment->setAuthor($this->getReference('user_admin'));
                $comment->setPublished($this->faker->dateTimeThisYear);
                $comment->setVlogPosts($this->getReference("vlog_post_$i"));

                $manager->persist($comment);
            }
        }
        $manager->flush();
    }
    public function loadUsers(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'Tololo123'));
        $user->setName('Oamogetswe');
        $user->setSurname('Mgidi');
        $user->setEmail('admin@vlogposts.com');

        $this->addReference('user_admin', $user);

        $manager->persist($user);
        $manager->flush();
    }
}
