<?php

namespace App\Controller;

use App\Controller\Api\MessagesController;
use App\Entity\Messages\Dialogue;
use App\Entity\Messages\Letter;
use App\Entity\User\Account;
use App\Form\Messages\SendingType;
use App\Repository\Messages\DialogueRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DialogueController extends AbstractController
{
    #[Route('/dialogs', name: 'app_dialogs')]
    public function dialogs(ManagerRegistry $registry): Response
    {
        $user_id = $this->getUser()->getId();

        /** @var DialogueRepository $dialogRepository */
        $dialogRepository = $registry->getRepository(Dialogue::class);

        $dialogs = $dialogRepository->findDialogs($user_id);

        $dialogView = [];

        /** @var Dialogue $dialog */
        foreach ($dialogs as $dialog) {
            if ($dialog['from_u_id'] == $user_id) {
                if (array_search($dialog['to_u_id'], $dialogView) === false) {
                    array_push($dialogView, $dialog['to_u_id']);
                }
            } elseif ($dialog['to_u_id'] == $user_id) {
                if (array_search($dialog['from_u_id'], $dialogView) === false) {
                    array_push($dialogView, $dialog['from_u_id']);
                }
            }
        }

        return $this->render('dialogue/index.html.twig', [
            'profiles' => $dialogView
        ]);
    }

    #[Route('/dialogs/with/{id}', name: 'app_dialogs_with_id')]
    public function dialogsWithId(int $id, ManagerRegistry $registry): Response
    {
        $sending = $this->createForm(SendingType::class);
        $vis = $registry->getRepository(Account::class)->findOneBy(['id' => $id]);
        $messages = $registry->getRepository(Dialogue::class)->findMessages($this->getUser()->getId(), $vis->getId());

        return $this->render('dialogue/with.html.twig', [
            'messages' => $messages,
            'sending' => $sending->createView(),
            'vis' => $vis,
        ]);
    }

//    const NEW_DIALOGUE = "Новый диалог";
//
//    private readonly ManagerRegistry $registry;
//
//    function __construct(ManagerRegistry $registry)
//    {
//        $this->registry = $registry;
//    }

//    #[Route('/dialogs', name: 'app_route_dialogs')]
//    public function getDialogs(): Response
//    {
//        $user = $this->getUser();
//
//        $dialogs = $this->registry->getRepository(Participants::class)->findDialogs($user->getUserIdentifier());
//        dd($dialogs);
//
//        return $this->render('dialogue/index.html.twig', [
//            'controller_name' => 'DialogueController',
//        ]);
//    }
//
//    #[Route('/dialogue/{hash}', name: 'app_route_dialog_page')]
//    public function dialogPage($hash): Response
//    {
//        $user = $this->getUser();
//        $partner = null;
//
//        $dialogue = $this->registry->getRepository(Dialogue::class)->findOneBy(['dialog_hash' => $hash]);
//        $participants = $this->registry->getRepository(Participants::class)->findBy(['dialog_id' => $dialogue->getId()]);
//
//        foreach ($participants as $participant) {
//            if ($participant->getUserId() != $user->getId()) {
//                $partner = $this->registry->getRepository(Account::class)->findOneBy(['id' => $participant->getUserId()]);
//            }
//        }
//
//        $messages = $this->registry->getRepository(Messages::class)->findBy(['dialog_id' => $dialogue->getId()]);
//
//        if (is_null($partner)) {
//            $this->redirectToRoute('app_route_home');
//        }
//
//        $send_form = $this->createForm(SendMessagesType::class);
//
//
//        return $this->render('dialogue/dialogue-page.html.twig', [
//            'send_form' => $send_form->createView(),
//            'you' => $user,
//            'partner' => $partner,
//            'messages' => $messages,
//            'controller_name' => 'DialogueController',
//        ]);
//    }
//
//    #[Route('/dialogue/message/create', name: 'app_route_dialog_message_create')]
//    public function apiCreateMessage(Request $request): JsonResponse
//    {
//        $form = $this->createForm(SendMessagesType::class);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            return $this->json($request->request->all());
//        }
//
//        return $this->json('error');
//    }
//
//    #[Route('/dialogue/find/{partner_id}', name: 'app_route_dialog_find_page')]
//    public function dialogFindPage($partner_id): Response
//    {
//        $user = $this->getUser();
//        $user_id = $user->getId();
//
//        $dialogue = $this->registry->getRepository(Participants::class)->findUnity($user_id, $partner_id);
//
//        if (count($dialogue) < 1) {
//            $manager = $this->registry->getManager();
//            $dialogue = new Dialogue();
//
//            $dialogue->setTitle(self::NEW_DIALOGUE);
//            $hash = $dialogue->setDialogHash(hash('sha256', ($user_id * $partner_id) . time()));
//
//            $manager->persist($dialogue);
//            $manager->flush();
//
//            foreach ([$user_id, $partner_id] as $user) {
//                $participants = new Participants();
//                $participants->setDialogId($dialogue->getId());
//                $participants->setUserId($user);
//                $participants->setRole(['DIALOGUE_USER']);
//                $manager->persist($participants);
//                $manager->flush();
//            }
//        } else {
//            $hash = $dialogue[0]['dialog_hash'];
//        }
//
//        return $this->redirectToRoute('app_route_dialog_page', ['hash' => $hash]);
//    }
}
