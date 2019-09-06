<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post")
 */
class PostController extends AbstractController {
    /**
     * @Route("/new", name="new_post")
     */
    public function newAction(Request $request) {
        $post = new Post();
        $post->setTitle('my brand new post');
        $post->setContent('this is the content of my first post.');
        $post->setAuthor('yassine');

        $form = $this->createFormBuilder()
            ->add('title', TextType::class)
            ->add('content', TextType::class)
            ->add('author', TextType::class)
            ->add('creationDate', DateType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Post'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash(
                'notice',

                'Post added successfully!'
            );

            return $this->redirectToRoute('list_post');
        }

        return $this->render('default/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function removeAction() {

    }

    public function updateAction() {

    }

    /**
     * @Route("/list", name="list_post")
     */
    public function getAction() {
        $repository = $this->getDoctrine()
            ->getRepository(Post::class);

        $posts = $repository->findAll();

        return $this->render('default/list.html.twig', array('posts' => $posts));
    }
}
