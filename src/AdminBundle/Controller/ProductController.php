<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/product")
 */
class ProductController extends Controller
{

    /**
     * @Route("/list")
     * @Template()
     */
    public function listAction()
    {
        return array(
                // ...
        );
    }

    /**
     * @Route("/new")
     * @Template()
     */
    public function newAction()
    {
        return array(
                // ...
        );
    }

    /**
     * @Route("/edit/{id}")
     * @Template()
     */
    public function editAction($id)
    {
        return array(
                // ...
        );
    }

    /**
     * @Route("/delete/{id}")
     * @Template()
     */
    public function deleteAction($id)
    {
        return array(
                // ...
        );
    }

}
