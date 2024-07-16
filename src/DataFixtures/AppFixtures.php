<?php

namespace App\DataFixtures;

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
        $this->loadVlogPosts($manager);
    }

    public function loadVlogPosts(ObjectManager $manager): void
    {
        $vlogPosts = new VlogPost();
        $vlogPosts->setTitle($this->faker->realText(30));
        $vlogPosts->setPublish($this->faker->dateTimeThisYear);
        $vlogPosts->setContent($this->faker->realText());
        $vlogPosts->setAuthor($this->faker->name);
        $vlogPosts->setSlug($this->faker->slug);

        $manager->persist($vlogPosts);
        $manager->flush();
    }
}
