<?php

namespace App\EventListener;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Type;
use App\Service\Slugger;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class SluggerListener
{
    // Dependancy injection. In this case, our slugger service
    private $slugger;

    public function __construct(Slugger $slugger)
    {
        // We inject the slugger service in our class by assigning the slugger service to our $slugger private property
        $this->slugger = $slugger;
    }

    /**
     * Sluggifies the category name
     *
     * @param Category $category the category entity
     * @return void
     */
    public function changeCategorySlug (Category $category, LifecycleEventArgs $event)
    {
        $category->setSlug($this->slugger->sluggify($category->getName()));
    }

    /**
     * Sluggifies the type name
     *
     * @param Type $type the type entity
     * @return void
     */
    public function changeTypeSlug (Type $type, LifecycleEventArgs $event)
    {
        $type->setSlug($this->slugger->sluggify($type->getName()));
    }

    /**
     * Sluggifies our product name
     *
     * @param Product $product the product entity
     * @return void
     */
    public function changeProductSlug (Product $product, LifecycleEventArgs $event)
    {
        $product->setSlug($this->slugger->sluggify($product->getName()));
    }
}