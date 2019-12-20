<?php

namespace App\Controller;

use App\Form\ContactType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController {

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, \Swift_Mailer $mailer) {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();

            $message = (new \Swift_Message('You Got Mail!'))
                ->setFrom(['info@altrecords.com' => 'ALT RECORDS'])
                ->setTo('pierre.lejeune.ipeps@gmail.com')
                ->setSubject('Notifications ALT RECORDS - Nouveau message reçu de l\'utilisateur [' . $contactFormData['name'] . ']')
                ->setBody('Le message reçu de [' . $contactFormData['name'] . '] est le suivant : ' . $contactFormData['message'],'text/plain')
            ;

            $mailer->send($message);

            $this->addFlash(
                'contactok',
                'Votre message a été envoyé avec succès.'
            );

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/contact.html.twig', [
            'contact_form' => $form->createView()
        ]);
    }
}
