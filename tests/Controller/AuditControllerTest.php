<?php

namespace App\Test\Controller;

use App\Entity\Audit;
use App\Repository\AuditRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuditControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private AuditRepository $repository;
    private string $path = '/audit/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Audit::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Audit index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'audit[auditDate]' => 'Testing',
            'audit[findings]' => 'Testing',
            'audit[recommendations]' => 'Testing',
            'audit[status]' => 'Testing',
        ]);

        self::assertResponseRedirects('/audit/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Audit();
        $fixture->setAuditDate('My Title');
        $fixture->setFindings('My Title');
        $fixture->setRecommendations('My Title');
        $fixture->setStatus('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Audit');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Audit();
        $fixture->setAuditDate('My Title');
        $fixture->setFindings('My Title');
        $fixture->setRecommendations('My Title');
        $fixture->setStatus('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'audit[auditDate]' => 'Something New',
            'audit[findings]' => 'Something New',
            'audit[recommendations]' => 'Something New',
            'audit[status]' => 'Something New',
        ]);

        self::assertResponseRedirects('/audit/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getAuditDate());
        self::assertSame('Something New', $fixture[0]->getFindings());
        self::assertSame('Something New', $fixture[0]->getRecommendations());
        self::assertSame('Something New', $fixture[0]->getStatus());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Audit();
        $fixture->setAuditDate('My Title');
        $fixture->setFindings('My Title');
        $fixture->setRecommendations('My Title');
        $fixture->setStatus('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/audit/');
    }
}
