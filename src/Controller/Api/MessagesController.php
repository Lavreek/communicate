<?php

namespace App\Controller\Api;

use App\Entity\Messages\Dialogue;
use App\Entity\Messages\Letter;
use App\Form\Messages\SendingType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MessagesController extends AbstractController
{
    #[Route('/api/message/get', name: 'api_message_get', methods: ['POST'])]
    public function apiMessageGet(Request $request, ManagerRegistry $registry): JsonResponse
    {
        $data = $request->request->get('url');
        if (!preg_match('#/dialogs/with/(\d+)#', $data, $matches)) {
            return new JsonResponse();
        }

        $letterRepo = $registry->getRepository(Letter::class);

        $messages = $registry->getRepository(Dialogue::class)->findMessages($this->getUser()->getId(), $matches[1][0]);
        $messagesResult = [];

        /** @var Dialogue $message */
        foreach ($messages as $message) {
            /** @var Letter $letter */
            $letter = $letterRepo->findOneBy(['id' => $message->getMessageId()]);
            $from = "none";

            if ($message->getFromUid() != $this->getUser()->getId()) {
                $from = "vis";
            } else {
                $from = "user";
            }

            array_push($messagesResult, ['id' => $message->getId(), 'text' => $letter->getMessage(), 'from' => $from]);
        }

        return new JsonResponse(['messages' => $messagesResult]);
    }

    private function managerSave(ManagerRegistry $registry, mixed $entity) : mixed
    {
        $manager = $registry->getManager();
        $manager->persist($entity);
        $manager->flush();

        return $entity;
    }

    #[Route('/api/message/send', name: 'api_message_send', methods: ['POST'])]
    public function apiMessageSend(Request $request, ManagerRegistry $registry): JsonResponse
    {
        $sendForm = $this->createForm(SendingType::class);
        $sendForm->handleRequest($request);

        if ($sendForm->isSubmitted() and $sendForm->isValid()) {

            $user = $this->getUser();
            $task = $sendForm->getData();

            $letter = new Letter();
            $letter->setMessage($task['message']);
            $letter->setType('text/plain');

            /** @var Letter $letter */
            $letter = $this->managerSave($registry, $letter);

            $dialogue = new Dialogue();
            $dialogue->setFromUid($user->getId());
            $dialogue->setSended(new \DateTime(date('Y-m-d H:i:s')));
            $dialogue->setMessageId($letter->getId());
            $dialogue->setToUid($task['vis']);

            $this->managerSave($registry, $dialogue);

            return new JsonResponse();
        }

        return new JsonResponse();
    }
}
