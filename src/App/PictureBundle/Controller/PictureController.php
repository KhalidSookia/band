<?php

namespace App\PictureBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\PictureBundle\Entity\Picture;
use App\PictureBundle\Form\PictureType;

/**
 * Picture controller.
 * @Route("/picture")
 */
class PictureController extends Controller
{

    /**
     * Lists all Picture entities.
     *
     * @Route("/", name="picture")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $collection = $em->getRepository('AppPictureBundle:Collection')->findByUser($user);

        if(null == $collection){
            return $this->redirect($this->generateUrl('collection'));
        }else{
            $entities = $em->getRepository('AppPictureBundle:Picture')->findByCollection($collection);
        }
        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Picture entity.
     *
     * @Route("/create", name="picture_create")
     * @Method("POST")
     * @Template("AppPictureBundle:Picture:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Picture();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('picture_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Picture entity.
    *
    * @param Picture $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Picture $entity)
    {
        $securityContext = $this->container->get('security.context');
        $form_ = $this->createForm(
            new PictureType($securityContext), 
            $entity, 
            array('action' => $this->generateUrl('picture_create'), 'method' => 'POST',)

            );

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Picture entity.
     *
     * @Route("/new", name="picture_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Picture();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Picture entity.
     *
     * @Route("/{id}", name="picture_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppPictureBundle:Picture')->find($id);
        var_dump($entity);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Picture entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Picture entity.
     *
     * @Route("/{id}/edit", name="picture_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppPictureBundle:Picture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Picture entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Picture entity.
    *
    * @param Picture $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Picture $entity)
    {
        $form = $this->createForm(new PictureType(), $entity, array(
            'action' => $this->generateUrl('picture_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Picture entity.
     *
     * @Route("/{id}", name="picture_update")
     * @Method("PUT")
     * @Template("AppPictureBundle:Picture:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppPictureBundle:Picture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Picture entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('picture_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Picture entity.
     *
     * @Route("/delete/{id}", name="picture_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppPictureBundle:Picture')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Picture entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('picture'));
    }

    /**
     * Creates a form to delete a Picture entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('picture_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
