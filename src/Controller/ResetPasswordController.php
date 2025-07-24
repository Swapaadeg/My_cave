<?php

namespace App\Controller;

use App\Form\ResetPasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ResetPasswordController extends AbstractController
{
    // DEMANDE DE MDP
    #[Route('/mot/de/passe', name: 'request')]
    public function request(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);

        if ($form ->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $user = $userRepository->findOneBy(['email' => $email]);

            if ($user) {
                $token = Uuid::v4()->toRfc4122();
                $user->setResetToken($token);
                $user->setResetTokenExpiresAt((new \DateTime())->modify('+1 hour'));

                $entityManager->flush();

                $resetLink = $this->generateUrl('reset', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
                $email = (new Email())
                    ->from('noreply@yourdomain.com')
                    ->to($user->getEmail())
                    ->subject('Réinitialisation de votre mot de passe')
                    ->text("Voici votre lien de réinitialisation : $resetLink");

                    $mailer->send($email);
                    $this->addFlash('success', 'un email de réinitialisation a été envoyé.');

                    return $this->redirectToRoute('login');
            }

            $this->addFlash('error', 'Aucun utilisateur trouvé pour cet email.');
        }

        return $this->render('mot_de_passe/request.html.twig', [
            'requestForm' => $form->createView(),
        ]);
    }


// RESET 

    #[Route('/mot/de/passe/{token}', name: 'reset')]
    public function reset(string $token, Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->findOneBy(['resetToken' => $token]);
        if (!$user || !$user->isResetTokenValid()) {
            $this->addFlash('danger', 'Ce lien de réinitialisation est invalide ou expiré.');
            return $this->redirectToRoute('request');
        }

        $form = $this->createForm(ResetPasswordFormType::class);
        $form->handleRequest($request);

        if ($form ->isSubmitted() && $form->isValid()) {
            $password=$form->get('plainPassword')->getData();
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $user->setPassword($hashedPassword);

            $user->setResetToken(null);
            $user->setResetTokenExpiresAt(null);

            $entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe a été mis à jour avec succès.');
            return $this->redirectToRoute('login');
        }

        return $this->render('mot_de_passe/reset.html.twig', [
            'resetForm' => $form->createView(),
        ]);
    }
}