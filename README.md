Simple news bundle with sonata backend
======================================

The bundle implements the news on the site, there is also the opportunity to share the news site
and news on the home page (using the checkboxes in the admin on mayn), allow orm and mongodb

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

3. Creating your entity/document
-----------------------

for orm:
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

for mongodb:
``` php
<?php
namespace MyBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use SIP\NewsBundle\Document\News as BaseNews;

/**
 * @MongoDB\Document(collection="content_news")
 */
class News extends BaseNews
{
    /**
     * @MongoDB\Id
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

4. Updating database schema(only for orm)
---------------------------

``` bash
$ php app/console doctrine:schema:update --force
```

This should be done only in dev environment! We recommend using Doctrine migrations(only for orm), to safely update your schema.

5. Importing routing configuration
----------------------------------

``` yml
SIPNewsBundle:
    resource: '@SIPNewsBundle/Resources/config/routing.yml'
    prefix:   /news
```

6. Configuration:
-----------------

for orm:

``` yml
# app/config/config.yml
sip_news:
    model: MyBundle\Entity\News
    # All Default configuration:
    # controller: SIP\\NewsBundle\\Controller\\NewsController
    # manager_type: orm
    # repository: Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository
    # admin: SIP\NewsBundle\Admin\NewsAdmin
```

for mongodb:

``` yml
# app/config/config.yml
sip_news:
    model: MyBundle\Document\SIP\News
    # controller: SIP\\NewsBundle\\Controller\\NewsController
    manager_type: mongodb
    repository: SIP\ResourceBundle\Repository\ODM\MongoDB\DocumentRepository
    # admin: SIP\NewsBundle\Admin\NewsAdmin
```

7. Templates
------------

The bundle requires show.html and list.html templates.
Easiest way to override the view is placing it here
app/Resources/SIPNewsBundle/views/News/index.html.twig
app/Resources/SIPNewsBundle/views/News/item.html.twig
app/Resources/SIPNewsBundle/views/News/main_index.html.twig.

8. Usage
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

        return $this->render('MyBundle:Main:index.html.twig',
            array('recentNews'     => $recentNews));
    }
}
```

Template(index.html.twig):

``` twig
...
<div class="fluid-row" style="overflow: hidden;">
    {% for news in recentNews %}

    <div class="span3 well well-small">
        <a href="{{ path('sip_news_news_item', {'slug': news.slug})}}" class="thumbnail" style="width: 130px; height: 75px;">
            {% media news.image, 'normal' %}
        </a>
        <hr />

        <h4>
            <a href="{{ path('sip_news_news_item', {'slug': news.slug})}}">
                {{ news.title|slice(0, 20) }}...
            </a>
        </h4>

        <p>{{ news.description|slice(0, 50)|raw }}...</p>
        <p><a href="{{ path('sip_news_news_item', {'slug': news.slug})}}" class="btn pull-right">Read more</a>
    </div>

    {% if loop.index % 4 == 0 %}
</div>
<div class="fluid-row">
    {% endif %}

    {% endfor %}
</div>
...
```