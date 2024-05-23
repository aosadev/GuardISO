<?php

namespace App\Test\Controller;

use App\Entity\SecurityIncident;
use App\Repository\SecurityIncidentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityIncidentControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private SecurityIncidentRepository $repository;
    private string $path = '/security/incident/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(SecurityIncident::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('SecurityIncident index');

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
            'security_incident[incidentDate]' => 'Testing',
            'security_incident[description]' => 'Testing',
            'security_incident[severity]' => 'Testing',
            'security_incident[resolved]' => 'Testing',
        ]);

        self::assertResponseRedirects('/security/incident/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new SecurityIncident();
        $fixture->setIncidentDate('My Title');
        $fixture->setDescription('My Title');
        $fixture->setSeverity('My Title');
        $fixture->setResolved('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('SecurityIncident');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new SecurityIncident();
        $fixture->setIncidentDate('My Title');
        $fixture->setDescription('My Title');
        $fixture->setSeverity('My Title');
        $fixture->setResolved('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'security_incident[incidentDate]' => 'Something New',
            'security_incident[description]' => 'Something New',
            'security_incident[severity]' => 'Something New',
            'security_incident[resolved]' => 'Something New',
        ]);

        self::assertResponseRedirects('/security/incident/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getIncidentDate());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getSeverity());
        self::assertSame('Something New', $fixture[0]->getResolved());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new SecurityIncident();
        $fixture->setIncidentDate('My Title');
        $fixture->setDescription('My Title');
        $fixture->setSeverity('My Title');
        $fixture->setResolved('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/security/incident/');
    }
}
