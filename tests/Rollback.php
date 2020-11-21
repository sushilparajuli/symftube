<?php

namespace App\Tests;

trait Rollback {

  public function setUp()
  {
    parent::setUp();
    $this->client = static::createClient([], [
      'PHP_AUTH_USER' => 'sushilparajuli@email.com',
      'PHP_AUTH_PW' => 'password',
    ]);
    $this->client->disableReboot(); //prevents from shutting down the kernel between test request and thus losing transactions

    $this->entityManager = $this->client->getContainer()->get('doctrine.orm.entity_manager');
    // for test isolation
   // $this->entityManager->beginTransaction();
    //$this->entityManager->getConnection()->setAutoCommit(false);
  }

  public function tearDown(): void
  {
    parent::tearDown();
    // for test isolation
    //$this->entityManager->rollback();
    $this->entityManager->close();
    $this->entityManager = null; // to avoid memory leak
  }
}