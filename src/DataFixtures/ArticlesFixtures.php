<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;

class ArticlesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for($i= 1; $i <=10; $i++)
        {
            $article = new Article();
            $article->setTitle("Titre de l'article n°$i");
            $article->setContent("<p>Contenu de l'article n°$i</p>");
            $article->setImage("http://placehold.it/350x150");
            $article->setCreatedAt(new \DateTime());

            $manager->persist($article);
        }
        $manager->flush();
    }
}
