<?php

namespace App\Controller;

use App\Entity\Messages\Dialogue;
use App\Entity\Messages\Messages;
use App\Entity\Messages\Participants;
use App\Entity\User\Account;
use App\Form\Messages\SendMessagesType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DialogController extends AbstractController
{
    const NEW_DIALOGUE = "Новый диалог";

    private readonly ManagerRegistry $registry;

    function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    #[Route('/dialogs', name: 'app_route_dialogs')]
    public function getDialogs(): Response
    {
        $user = $this->getUser();

        $dialogs = $this->registry->getRepository(Participants::class)->findDialogs($user->getUserIdentifier());
        dd($dialogs);

        return $this->render('dialog/dialogs.html.twig', [
            'controller_name' => 'DialogController',
        ]);
    }

    #[Route('/dialog/{hash}', name: 'app_route_dialog_page')]
    public function dialogPage($hash): Response
    {
        $user = $this->getUser();
        $partner = null;

        $dialog = $this->registry->getRepository(Dialogue::class)->findOneBy(['dialog_hash' => $hash]);
        $participants = $this->registry->getRepository(Participants::class)->findBy(['dialog_id' => $dialog->getId()]);

        foreach ($participants as $participant) {
            if ($participant->getUserId() != $user->getId()) {
                $partner = $this->registry->getRepository(Account::class)->findOneBy(['id' => $participant->getUserId()]);
            }
        }

        $messages = $this->registry->getRepository(Messages::class)->findBy(['dialog_id' => $dialog->getId()]);

        if (is_null($partner)) {
            $this->redirectToRoute('app_route_home');
        }

        $send_form = $this->createForm(SendMessagesType::class);


        return $this->render('dialog/dialog-page.html.twig', [
            'send_form' => $send_form->createView(),
            'you' => $user,
            'partner' => $partner,
            'messages' => $messages,
            'controller_name' => 'DialogController',
        ]);
    }

    #[Route('/dialog/message/create', name: 'app_route_dialog_message_create')]
    public function apiCreateMessage(Request $request): JsonResponse
    {
        $form = $this->createForm(SendMessagesType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->json($request->request->all());
        }

        return $this->json('error');
    }

    #[Route('/dialog/find/{partner_id}', name: 'app_route_dialog_find_page')]
    public function dialogFindPage($partner_id): Response
    {
        $user = $this->getUser();
        $user_id = $user->getId();

        $dialog = $this->registry->getRepository(Participants::class)->findUnity($user_id, $partner_id);

        if (count($dialog) < 1) {
            $manager = $this->registry->getManager();
            $dialog = new Dialogue();

            $dialog->setTitle(self::NEW_DIALOGUE);
            $hash = $dialog->setDialogHash(hash('sha256', ($user_id * $partner_id) . time()));

            $manager->persist($dialog);
            $manager->flush();

            foreach ([$user_id, $partner_id] as $user) {
                $participants = new Participants();
                $participants->setDialogId($dialog->getId());
                $participants->setUserId($user);
                $participants->setRole(['DIALOGUE_USER']);
                $manager->persist($participants);
                $manager->flush();
            }
        } else {
            $hash = $dialog[0]['dialog_hash'];
        }

        return $this->redirectToRoute('app_route_dialog_page', ['hash' => $hash]);
    }
}
