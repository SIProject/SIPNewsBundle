Simple news bundle with sonata backend
======================================

The bundle implements the news on the site, there is also the opportunity to share the news site
and news on the home page (using the checkboxes in the admin onmayn)

Installation
============

1. command to add the bundle to your composer.json and download package.
------------------------------------------------------------------------

``` bash
$ composer require "sip/news-bundle": "dev-master"
```

2. Enable the bundle inside the kernel.
---------------------------------------

``` php
<?php

// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        new SIP\NewsBundle\SIPNewsBundle(),
        new Genemu\Bundle\FormBundle\GenemuFormBundle(),
        // If you wish to use SonataAdmin
        new Sonata\BlockBundle\SonataBlockBundle(),
        new Sonata\jQueryBundle\SonatajQueryBundle(),
        new Sonata\AdminBundle\SonataAdminBundle(),

        // Other bundles...
    );
}
```

[Read more about installation SonataAdminBundle](http://sonata-project.org/bundles/admin/master/doc/reference/installation.html#installation)

3. Creating your entity
-----------------------

``` php
<?php
namespace MyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SIP\NewsBundle\Entity\News as BaseNews;

/**
 * @ORM\Entity
 * @ORM\Table(name="content_news")
 */
class News extends BaseNews
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
```

4. Updating database schema
---------------------------

``` bash
$ php app/console doctrine:schema:update --force
```

This should be done only in dev environment! We recommend using Doctrine migrations, to safely update your schema.

5. Importing routing configuration
----------------------------------

``` yml
SIPNewsBundle:
    resource: '@SIPNewsBundle/Resources/config/routing.yml'
    prefix:   /news
```

6. Templates
------------

The bundle requires show.html and list.html templates.
Easiest way to override the view is placing it here
app/Resources/SIPNewsBundle/views/News/show.html.twig
app/Resources/SIPNewsBundle/views/News/list.html.twig.

7. Usage
--------

Show news on main page:

Controller:

``` php
<?php

namespace MyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $recentNews = $this
            ->getNewsRepository()
            ->findBy(array('onMain' => 1), array('date' => 'desc'), 8);

        return $this->render('SIPResourceBundle:Main:index.html.twig',
            array('recentNews'     => $recentNews));
    }
}
```

Template:

<div class="fluid-row" style="overflow: hidden;">
    {% for news in recentNews %}

    <div class="span3 well well-small">
        <a href="{{ path('sip_news_show', {'slug': news.slug})}}" class="thumbnail" style="width: 130px; height: 75px;">
            {% media news.image, 'normal' %}
        </a>
        <hr />

        <h4>
            <a href="{{ path('sip_news_show', {'slug': news.slug})}}">
                {{ news.title|slice(0, 20) }}...
            </a>
        </h4>

        <p>{{ news.description|slice(0, 50)|raw }}...</p>
        <p><a href="{{ path('sip_news_show', {'slug': news.slug})}}" class="btn pull-right">Read more</a>
    </div>

    {% if loop.index % 4 == 0 %}
</div>
<div class="fluid-row">
    {% endif %}

    {% endfor %}
</div>
