<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/blog")
 */

class BlogController extends Controller
{
    /**
     * @Route("/", name="show-blog")
     */
    public function showBlogAction()
    {
        $em = $this->getDoctrine()
            ->getManager();
        $posts = $em->getRepository('AppBundle:Post')
            ->findAll();

        return $this->render('blog/show.html.twig',[
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/{slug}", name="show-blog-post")
     */
    public function showBlogPostAction(Post $post)
    {
        return $this->render('blog/show-post.html.twig',[
            'post' => $post
        ]);
    }
}