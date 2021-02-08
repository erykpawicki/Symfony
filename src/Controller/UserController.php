<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends AbstractController
{

    private $passwordEncoder;

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function register(Request $request, TranslatorInterface $translator)
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('homepage');
        }

        //Simple forms example -> no dedicated class, build form "on the fly" based on existing "User entity" to perform login action.
        $user = new User();
        $form = $this->createFormBuilder($user)
            ->add('email', TextType::class, [
                'label' => $translator->trans('My email is:')
            ])
            ->add('first_name', TextType::class, [
                'label' => $translator->trans('My first name is:')
            ])
            ->add('last_name', TextType::class, [
                'label' => $translator->trans('My last name is:')
            ])
            ->add('password', PasswordType::class, [
                'label' => $translator->trans('And my password will be:')
            ])
            ->add('login', SubmitType::class, ['label' => 'Log me in'])
            ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $userExists = false;

            //TODO: check if user exists, if yes, do not allow to create it and throwr an error message
            if (!$userExists) {
                $user = new User();
                $user->setIsBlocked(0);
                $user->setFirstName($form->get('first_name')->getData());
                $user->setLastName($form->get('last_name')->getData());
                $user->setEmail($form->get('email')->getData());
                $user->setPassword($this->passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()));

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($user);
                $manager->flush();
                return $this->redirectToRoute('homepage');
            } else {
                //TODO: process error for user creation, when actual user exists...
            }
        }
        return $this->render('eti/blog/register.html.twig',
            [
                'register_form' => $form->createView()
            ]);
    }
}