<?php

namespace App\Tests\Controllers;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerCategoriesTest extends WebTestCase
{
    // This will be invoked on every class having test keyword
    public function setUp()
    {
        parent:: setUp();
        $this->client = static::createClient();
    }

    public function testTextOnPage()
    {

        $crawler = $this->client->request('GET', '/admin/categories');
        $this->assertSame('Categories list', $crawler->filter('h2')->text());
        $this->assertContains('Electronics',  $this->client->getResponse()->getContent());
    }
}
