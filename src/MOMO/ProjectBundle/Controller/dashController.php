<?php

namespace MOMO\ProjectBundle\Controller;

use MOMO\ProjectBundle\Entity\dash;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Dash controller.
 *
 */
class dashController extends Controller
{
    /**
     * Lists all dash entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dashes = $em->getRepository('ProjectBundle:dash')->findAll();

        return $this->render('dash/index.html.twig', array(
            'dashes' => $dashes,
        ));
    }

    /**
     * Creates a new dash entity.
     *
     */
    public function newAction(Request $request)
    {
        $dash = new Dash();
        $form = $this->createForm('MOMO\ProjectBundle\Form\dashType', $dash);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dash);
            $em->flush();

            return $this->redirectToRoute('projects_show', array('id' => $dash->getId()));
        }

        return $this->render('dash/new.html.twig', array(
            'dash' => $dash,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a dash entity.
     *
     */
    public function showAction(dash $dash)
    {
        $deleteForm = $this->createDeleteForm($dash);

        return $this->render('dash/show.html.twig', array(
            'dash' => $dash,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing dash entity.
     *
     */
    public function editAction(Request $request, dash $dash)
    {
        $deleteForm = $this->createDeleteForm($dash);
        $editForm = $this->createForm('MOMO\ProjectBundle\Form\dashType', $dash);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('projects_edit', array('id' => $dash->getId()));
        }

        return $this->render('dash/edit.html.twig', array(
            'dash' => $dash,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a dash entity.
     *
     */
    public function deleteAction(Request $request, dash $dash)
    {
        $form = $this->createDeleteForm($dash);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dash);
            $em->flush();
        }

        return $this->redirectToRoute('projects_index');
    }

    /**
     * Creates a form to delete a dash entity.
     *
     * @param dash $dash The dash entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(dash $dash)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('projects_delete', array('id' => $dash->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
