<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\User;
use App\Entity\VlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    /**
     * @var Factory
     */
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }
    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
        $this->loadVlogPosts($manager);
    }
    public function loadVlogPosts(ObjectManager $manager): void
    {
        $user = $this->getReference('user_admin');
        $vlogPost = new VlogPost();
        $vlogPost->setTitle($this->faker->sentence());
        $vlogPost->setPublished($this->faker->dateTimeThisYear);
        $vlogPost->setContent($this->faker->paragraph());
        $vlogPost->setAuthor($user);
        $vlogPost->setSlug($this->faker->slug());

        $manager->persist($vlogPost);
        $manager->flush();
    }
    public function loadComments(ObjectManager $manager): void
    {
        $comment = new Comment();
    }
    public function loadUsers(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setPassword('Tololo123');
        $user->setName('Oamogetswe');
        $user->setSurname('Mgidi');
        $user->setEmail('admin@vlogposts.com');

        $this->addReference('user_admin', $user);

        $manager->persist($user);
        $manager->flush();
    }
}
