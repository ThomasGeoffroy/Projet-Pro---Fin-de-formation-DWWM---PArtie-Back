<?php

namespace App\DataFixtures;

use App\DataFixtures\Providers\AppProvider;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Type;
use App\Service\Slugger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    private $slugger;

    public function __construct(Slugger $slugger)
    {
        $this->slugger = $slugger;
    }
    
    public function load(ObjectManager $manager): void
    {
        // Creation of a french locale for the faker
        $faker = Faker\Factory::create("fr_FR");

        // Use of our custom AppProvider
        $faker->addProvider(new AppProvider());

        // Use of a populator
        $populator = new \Faker\ORM\Doctrine\Populator($faker, $manager);


        // ! Category

        // creation of the category class to populate
        $populator->addEntity(Category::class, 5,
        [
            // setting the name property with the provider
            "name" => function () use ($faker) {
                return $faker->unique()->categoryName();
            },
            // For the picture, we grabbed pictures from the picsum website
            "picture" => function () use ($faker) {
                return "https://picsum.photos/id/" . $faker->numberBetween(1, 200) . "/300/500";
            }
        ]
        );


        // ! Type

        $populator->addEntity(Type::class, 15,
        [
            "name" => function () use ($faker) {
                return $faker->unique()->TypeName();
            }
        ]
        );


        // ! Product

        $populator->addEntity(Product::class, 48,
        [
            "name" => function () use ($faker) {
                return $faker->unique()->productName();
            },
            "picture" => function () use ($faker) {
                return "https://picsum.photos/id/" . $faker->numberBetween(1, 200) . "/300/500";
            },
            "status" => function () use ($faker) {
                return $faker->numberBetween(1,1);
            },
            "size" => function () use ($faker) {
                return $faker->productSize();
            },
            "price" => function () use ($faker) {
                return $faker->numberBetween(500,5000);
            },
            "description" => function () use ($faker) {
                return $faker->text(200);
            },
            "ingredients" => function () use ($faker) {
                return $faker->text(200);
            },
            "advice" => function () use ($faker) {
                return $faker->text(200);
            }
        ]
        );

        // We execute the populator to add the data locally
        $insertedItems = $populator->execute();

        // ! Flush
        // We flush for syncing local data with the DB
        $manager->flush();
    }
}
