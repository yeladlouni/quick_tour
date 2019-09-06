<?php


namespace App\Controller;

use App\GreetingGenerator;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component
\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController
{
    /**
     * @Route("/hello/{name}")
     */
    public function hello($name) {
        return new Response("Hello $name");
    }

    /**
     * @Route("/test/{name}")
     */
    public function test($name) {
        return $this->render('default/index.html.twig', [
            'name' => $name
        ]);
    }

    public function index($name, LoggerInterface $logger, GreetingGenerator $generator)
    {
        $greeting = $generator->getRandomGreeting();
        $logger->info("Saying $greeting to $name!");

        return $this->render('default/index.html.twig', [
            'name' => $name,
        ]);
    }

    /**
     * @Route("/simplicity")
     */
    public function simple()
    {
        return new Response('Simple! Easy! Great!');
    }

    /**
     * @Route("/api/hello/{name}")
     */
    public function apiExample($name)
    {
        return $this->json([
            'name' => $name,
            'symfony' => 'rocks',
        ]);
    }

    /**
     * @Route("/blog/{id<\d+>}")
     */
    public function blog(Request $request, $id) {
        $page = $request->query->get('page', 1);

        return new Response("Post $id Page $page");
    }

    /**
     * @Route("/login")
     */
    public function login(SessionInterface $session) {
        $session->set('email', 'yeladlouni@gmail.com');
        $token = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
        $session->set('token', $token);

        return new Response("<form><input type='email' value='"
            .$session->get('email')."'/><input type='text' value='"
            .$session->get('token')."'/><input type='submit' value='Login'></form>");
    }

    /**
     * @Route("/info")
     */
    public function info(Request $request) {
        $request->isXmlHttpRequest();

        $request->getPreferredLanguage(['en', 'fr']);

        $request->query->get('page');
        $request->request->get('page');

        $request->server->get('HTTP_HOST');

        $request->files->get('foo');

        $request->cookies->get('PHPSESSID');

        $request->headers->get('host');
        $request->headers->get('content-type');

        return new Response("");
    }

}