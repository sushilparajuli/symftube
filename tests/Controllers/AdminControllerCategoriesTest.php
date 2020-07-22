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
        $this->client->disableReboot(); //prevents from shutting down the kernel between test request and thus losing transactions

        $this->entityManager = $this->client->getContainer()->get('doctrine.orm.entity_manager');
        // for test isolation
        $this->entityManager->beginTransaction();
        $this->entityManager->getConnection()->setAutoCommit(false);
    }

    public function tearDown(): void
    {
        parent::tearDown();
         // for test isolation
        $this->entityManager->rollback();
        $this->entityManager->close();
        $this->entityManager = null; // to avoid memory leak
    }

    public function testTextOnPage()
    {

        $crawler = $this->client->request('GET', '/admin/categories');
        $this->assertSame('Categories list', $crawler->filter('h2')->text());
        $this->assertContains('Electronics',  $this->client->getResponse()->getContent());
    }

    public function testNumbersOfItems()
    {
        $crawler = $this->client->request('GET', '/admin/categories');
        $this->assertCount(21, $crawler->filter('option'));
       
    }

    public function testNewCategory()
    {
        $crawler = $this->client->request('GET', '/admin/categories');
        $form = $crawler->selectButton('Add')->form([
            'category[parent]' => 1,
            'category[name]'=> 'Other Electronics'
        ]);
        $this->client->submit($form);

        $category = $this->entityManager->getRepository(Category::class)->findOneBy(
            ['name'=> 'Other Electronics']
        );
        $this->assertNotNull($category);
        $this->assertSame('Other Electronics', $category->getName());
    }

    public function testEditCategory()
    {
        $crawler = $this->client->request('GET', '/admin/edit-category/1');
        $form = $crawler->selectButton('Save')->form([
            'category[parent]' => 0,
            'category[name]' => 'Electronics 2'
        ]);
        $this->client->submit($form);

        $category = $this->entityManager->getRepository(Category::class)->find(1);
        $this->assertSame('Electronics 2', $category->getName());
    }

    public function testDeleteCategory()
    {
        $crawler = $this->client->request('GET', '/admin/delete-category/1');
        $category = $this->entityManager->getRepository(Category::class)->find(1);
        $this->assertNull($category);
    }
}
