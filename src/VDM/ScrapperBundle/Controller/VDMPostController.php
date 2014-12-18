<?php

namespace VDM\ScrapperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use VDM\ScrapperBundle\Entity\VDMPost;
use VDM\ScrapperBundle\Entity\VDMPostQuery;
use FOS\RestBundle\Controller\Annotations as Rest;


class VDMPostController extends Controller
{
    //retourne un post 
    public function getAction($id)
    {
        $repository = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('VDMScrapperBundle:VDMPost')
        ;
        $vdmPost = $repository->getVDMPostById($id);

        if( $vdmPost === null){
            throw new NotFoundHttpException ('No VDM post found');
        }
        
        $response = new Response();
        $response->setContent(json_encode(array(
            'post' => $vdmPost
        ), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_PRETTY_PRINT 
        ));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    //retourne un ensemble filtré de posts 
    public function allAction(Request $request)
    {
        $fromReq = $request->get('from');
        $toReq = $request->query->get('to');
        $authorReq = $request->query->get('author');

        $repository = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('VDMScrapperBundle:VDMPost')
        ;
        $vdmPosts = $repository->getVDMPostsWithCriteria ($authorReq, $fromReq, $toReq);

        $response = new Response();
        $response->setContent(json_encode(array(
            'posts' => $vdmPosts, 
            'count' => count($vdmPosts)
        ), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_PRETTY_PRINT 
        ));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


}
