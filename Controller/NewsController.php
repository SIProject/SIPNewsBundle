<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
namespace SIP\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class NewsController extends Controller
{
    /**
     * @Route("/{page}", requirements={"page" = "\d+"}, defaults={"page" = 1})
     * @Template("SIPNewsBundle:News:index.html.twig")
     */
    public function indexAction($page, $paginate = 8)
    {
        $pager = $this->getNewsRepository()->createPaginator(array(), array('date' => 'desc'))
                     ->setCurrentPage($page, true, true)
                     ->setMaxPerPage($paginate);

        return array('pager' => $pager);
    }

    /**
     * @Template("SIPNewsBundle:News:main_index.html.twig")
     */
    public function mainIndexAction($limit = 8)
    {
        $news = $this->getNewsRepository()->findBy(array('onMain' => true), array('date' => 'desc'), $limit);

        return array('news' => $news);
    }

    /**
     * @Route("/item-{id}", requirements={"id" = "\d+"})
     * @Template("SIPNewsBundle:News:item.html.twig")
     */
    public function itemAction($id)
    {
        $new = $this->getNewsRepository()->findOneBy(array('id' => $id));

        if (!$new) {
            throw $this->createNotFoundException("Unable to find entity");
        }

        return array('new' => $new);
    }

    /**
     * @return \SIP\ResourceBundle\Repository\EntityRepository
     */
    private function getNewsRepository()
    {
        return $this->get('sip_news.repository.new');
    }
}