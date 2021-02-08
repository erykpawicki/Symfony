<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Entity\Comment;
use App\Entity\User;
use App\Form\AddArticleType;
use App\Form\CommentType;
use App\Form\EditArticleType;
use App\Form\SettingsAccountType;
use App\Repository\BlogPostRepository;
use App\Repository\SampelRepository;
use App\Repository\UtworRepository;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class EtiController
 */
class EtiController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function blogHomepage()
    {
        return $this->render('eti/blog/homepage.html.twig');
    }

    /**
     * @Route("/settings_account", name="settings_account")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param UserInterface $user
     * @return Response
     */
    public function settingsAccount(Request $request, UserPasswordEncoderInterface $passwordEncoder, UserInterface $user)
    {
        $id = $this->getUser()->getId();


        $entityManager = $this->getDoctrine()->getManager();
        $userManager = $entityManager->getRepository(User::class)->find($id);


        $form= $this->createForm(SettingsAccountType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $firstName = $form->getData()->getFirstName();
            $lastName = $form->getData()->getLastName();
            $password = $form->getData()->getPassword();
            $password = $passwordEncoder->encodePassword($user, $password);

            $userManager->setFirstName($firstName);
            $userManager->setLastName($lastName);
            $userManager->setPassword($password);

            $entityManager->flush();
        }


        return $this->render('eti/settings/account.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/first/page", name="first_page")
     * @param TranslatorInterface $translator
     * @return Response
     * @throws Exception
     */
    public function randomNumber(TranslatorInterface $translator)
    {
        $number = random_int(0, 100);

        return $this->render('eti/blog/first_page.html.twig', [
            'number' => $number,
            'translated_php' => $translator->trans('Translated string'),
            'translated_php_pl' => $translator->trans('Translated string', [], 'messages', 'pl_PL')
        ]);
    }

    /**
     * @Route("add_article", name="add_article")
     * @param Request $request
     * @return Response
     */
    public  function addArticle(Request $request)
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('homepage');
        }

        $post = new BlogPost();

        $form= $this->createForm(AddArticleType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $tittle = $form->getData()->getTitle();
            $summary = $form->getData()->getSummary();
            $content = $form->getData()->getContent();
            $isVisible = $form->getData()->getIsVisible();
            $isLoggegOnly = $form->getData()->getIsLoggegOnly();


            $post->setTitle($tittle);
            $post->setSummary($summary);
            $post->setContent($content);
            $post->setCreationDate(new \DateTime());
            $post->setCreatorId($this->getUser()->getId());
            $post->setIsVisible($isVisible);
            $post->setIsLoggegOnly($isLoggegOnly);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();
        }

        return $this->render('eti/blog/add_article.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("edit_article/{id}", name="edit_article")
     * @param Request $request
     * @param BlogPost $blogPost
     * @param BlogPostRepository $repository
     * @param int $id
     * @return Response
     */
    public function edit_article(Request $request, BlogPost $blogPost, BlogPostRepository $repository, int $id)
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('homepage');
        } elseif ($this->getUser()->getId() != $blogPost->getCreatorId()) {
            return $this->redirectToRoute('homepage');
        }


        $post = $repository->find($id);

        $form= $this->createForm(EditArticleType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $tittle = $form->getData()->getTitle();
            $summary = $form->getData()->getSummary();
            $content = $form->getData()->getContent();
            $isVisible = $form->getData()->getIsVisible();
            $isLoggegOnly = $form->getData()->getIsLoggegOnly();


            $post->setTitle($tittle);
            $post->setSummary($summary);
            $post->setContent($content);
            $post->setCreationDate(new \DateTime());
            $post->setCreatorId($this->getUser()->getId());
            $post->setIsVisible($isVisible);
            $post->setIsLoggegOnly($isLoggegOnly);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Changes were saved');
        }

        return $this->render('eti/blog/edit_article.html.twig', [
            'form' => $form->createView(),
            'articles' => $blogPost

        ]);
    }


    /**
     * @Route("posts/list", name="post_listing")
     *
     * @param BlogPostRepository $blogPostRepository
     * @return Response
     */
    public function listBlogPosts(BlogPostRepository $blogPostRepository)
    {
//        $repository = $this->getDoctrine()->getRepository(BlogPost::class);

        if ($this->getUser() != null) {
            $user = $this->getUser()->getId();
        } else $user = null;

        $articles = $blogPostRepository->findBy([
            'is_visible' => true
        ]);

        return $this->render('eti/blog/posts.html.twig', [
            'articles' => $articles,
            'user' => $user
        ]);
    }


    /**
     * @Route("posts/view/{id}", name="post_details")
     *
     * @param BlogPost $blogPost
     * @param Request $request
     * @return Response
     */
    public function postDetails(BlogPost $blogPost, Request $request)
    {
        if ($this->getUser() == null && $blogPost->getIsVisible() == false) {
            return $this->redirectToRoute('homepage');
        } elseif ($this->getUser() == null) {

        } elseif (($blogPost->getCreatorId() !=  $this->getUser()->getId()) && $blogPost->getIsVisible() == false) {
            return $this->redirectToRoute('homepage');
        }

//        $comment = new Comment();
//        $comment->setContent();
//
//        $form = $this->createForm(CommentType::class);
//        $form->handleRequest($request);
//
//
//
        return $this->render('eti/blog/post_view.html.twig', [
            'articles' => $blogPost,
//            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("hidden_content", name="hidden_content")
     */
    public function hidden_content()
    {
        if ($this->getUser() != null) {
            $user = $this->getUser();
        } else return $this->redirectToRoute('homepage');

        $userName = $this->getUser()->getFirstName();
        $userLastName = $this->getUser()->getLastName();

        return $this->render('eti/hidden_content/information.html.twig', [
           'user' => $user,
            'userName' => $userName,
            'userLastName' => $userLastName
        ]);
    }

    /**
     * @Route("post_for_logged", name="post_for_logged")
     * @param BlogPostRepository $blogPostRepository
     * @return Response
     */
    public function postsForLoggedUsers(BlogPostRepository $blogPostRepository)
    {
//        $id = $this->getUser()->getId();

        if ($this->getUser() != null) {
            $id = $this->getUser()->getId();
        } else return $this->redirectToRoute('homepage');

        $articles = $blogPostRepository->findBy([
            'is_loggeg_only' => true
        ]);

        return $this->render('eti/blog/posts.html.twig', [
            'articles' => $articles,
            'user' => $id
        ]);
    }

    /**
     * @Route("/sample", name="sample")
     * @param SampelRepository $sampelRepository
     * @param UtworRepository $utworRepository
     * @return Response
     */
    public function sampeldetails(SampelRepository $sampelRepository, UtworRepository  $utworRepository)
    {
        $sample = $sampelRepository->findAll();
        $utwory = $utworRepository->findAll();


        return $this->render('eti/blog/homepage.html.twig', [
            'sample' => $sample,
            'utwory' => $utwory,

        ]);
    }
}