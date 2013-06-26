<?php
namespace Stubby\ShorteningServiceBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class DoctrineEnabledTestCase extends WebTestCase 
{

    protected $em;
    protected $conn;
    protected $container;

    public function setUp()
    {
        $this->getKernelClass();
        $kernel = new \AppKernel('test', true);
        $kernel->boot();

        $this->container = $kernel->getContainer();
        $this->em = $this->container->get('doctrine.orm.entity_manager');
        $this->conn = $this->em->getConnection();
        $this->conn->beginTransaction();
    }

    public function tearDown() 
    {
        if ($this->conn->isTransactionActive()) {
            $this->conn->rollback();
        }
    }
}
