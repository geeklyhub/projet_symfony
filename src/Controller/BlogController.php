<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundationon\Request;
use Symfony\Component\Routing\Annotation\Route;


class BlogController extends Controller
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo) ##Fait directement appel au fichier /Repository/ArticleRepository.php et crée une variable $repo
    {
        //$repo = $this->getDoctrine()->getRepository(Article::class); // Autre façon d'appeler le $repo | Permet de demander à doctrine un repository (article class)

        $articles = $repo->findAll();

        return $this->render('blog/articles.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/", name="home_page")
     */
    public function home()
    {
        return $this->render('blog/home.html.twig', [
            'title' => "Welcome !"]);
    }

    /**
     * @Route("/underconstruction", name="under_construction")
     */
    public function about()
    {
        return $this->render('blog/new.html.twig');
    }

    /**
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function form(Article $article = null, \Symfony\Component\HttpFoundation\Request $request, ObjectManager $manager)
    {
        if (!$article) {
            $article = new Article(); # dans la situation où je veux créer un nouvel article, je dois créer une instance de la classe Article
        }
        #Création du formulaire avec createFormBuilder avec en paramètre $article
        //$form = $this->createFormBuilder($article)
        //    ->add('title')
        //    ->add('content')
        //    ->add('image')
        //    ->getForm(); #permet d'obtenir le formulaire construit

        #simplification
        $form= $this->createForm(ArticleType::class, $article);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if(!$article->getId()) {
                $article->setCreatedAt(new \DateTime());
            }

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('article_show', ['id' => $article->getId()]);
            dump($article); # cela m'a permi de checker si les valeurs de l'articles se sont données aux contents de $article
        }

        return $this->render('blog/create.html.twig', [
            'formArticle' => $form->createView(),
            'editMode'=>$article->getId()!==null
        ]);
    }

    /**
     * @Route("/blog/{id}", name="article_show")
     */
    public function show(Article $article) # Ici on peux directement créer une variable $article de Article. Il comprendra que {id} représente la variable $article.
    {
        //$repo = $this->getDoctrine()->getRepository(Article::class);
        //$article = $repo->find($id);
        return $this->render('blog/show.html.twig', [
            'article' => $article
        ]);
    }

}
