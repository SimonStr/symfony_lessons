<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Post;
use AppBundle\Form\BlogPostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/** 
 * @Route("/admin")
 */
class BlogController extends Controller
{
    /**
     * @Route("/blog/post", name="admin_blog")
     */
    public function indexAction()
    {
        $posts = $this->getPostRepository()->findAll();

        return $this->render('blog/admin/blog/index.html.twig', [
            'posts' => $posts,
        ]);
    }
    
    /**
     * @Route("/blog/post/{id}/edit", name="admin_blog_post_edit")
     */    
    public function editBlogPostAction($id)
    {
        $post = $this->getPostRepository()->find($id);
        $form = $this->createEditBlogPostForm($post);
        
        return $this->render('blog/admin/blog/edit-post.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/blog/post/{id}/update", name="admin_blog_post_update")
     * @Method("POST")
     */
    public function updateBlogPostAction(Request $request, $id)
    {
        $post = $this->getPostRepository()->find($id);
        $form = $this->createEditBlogPostForm($post);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_blog');
        }

        return $this->render('blog/admin/blog/edit-post.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/blog/post/new", name="admin_blog_post_new")
     */
    public function newBlogPostAction()
    {
        $post = new Post();
        $form = $this->createForm(BlogPostType::class, $post, [
            'action' =>$this->generateUrl('admin_blog_post_create'),
        ]);

        return $this->render('blog/admin/blog/new-post.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/blog/post/create", name="admin_blog_post_create")
     */
    public function createBlogPostAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(BlogPostType::class, $post, [
            'action' =>$this->generateUrl('admin_blog_post_create'),
        ]);

        $form->handleRequest($request);
        if ($form->isValid()) {

            $doctrineManager = $this->getDoctrine()->getManager();

            $doctrineManager->persist($post);
            $doctrineManager->flush();

            return $this->redirectToRoute('admin_blog');
        }
        return $this->render('blog/admin/blog/new-post.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/blog/post/{id}/delete", name="admin_blog_post_delete")
     * @Method("POST")
     */
    public function deleteBlogPostAction($id)
    {
        $post = $this->getPostRepository()->find($id);
        $doctrineManager = $this->getDoctrine()->getManager();
        $doctrineManager->remove($post);
        $doctrineManager->flush();

        return $this->redirectToRoute('admin_blog');
    }

    private function getPostRepository()
    {
        return $this->getDoctrine()->getRepository(Post::class);
    }

    private function createEditBlogPostForm(Post $post)
    {
        return $this->createForm(BlogPostType::class, $post, [
            'action' =>$this->generateUrl('admin_blog_post_update', [
                'id' => $post->getId(),
            ]),
        ]);
    }
}