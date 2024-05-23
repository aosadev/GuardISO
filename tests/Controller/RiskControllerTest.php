<?php

namespace App\Test\Controller;

use App\Entity\Risk;
use App\Repository\RiskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RiskControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private RiskRepository $repository;
    private string $path = '/risk/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Risk::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Risk index');

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
            'risk[riskDescription]' => 'Testing',
            'risk[likelihood]' => 'Testing',
            'risk[impact]' => 'Testing',
            'risk[mitigationMeasures]' => 'Testing',
        ]);

        self::assertResponseRedirects('/risk/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Risk();
        $fixture->setRiskDescription('My Title');
        $fixture->setLikelihood('My Title');
        $fixture->setImpact('My Title');
        $fixture->setMitigationMeasures('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Risk');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Risk();
        $fixture->setRiskDescription('My Title');
        $fixture->setLikelihood('My Title');
        $fixture->setImpact('My Title');
        $fixture->setMitigationMeasures('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'risk[riskDescription]' => 'Something New',
            'risk[likelihood]' => 'Something New',
            'risk[impact]' => 'Something New',
            'risk[mitigationMeasures]' => 'Something New',
        ]);

        self::assertResponseRedirects('/risk/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getRiskDescription());
        self::assertSame('Something New', $fixture[0]->getLikelihood());
        self::assertSame('Something New', $fixture[0]->getImpact());
        self::assertSame('Something New', $fixture[0]->getMitigationMeasures());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Risk();
        $fixture->setRiskDescription('My Title');
        $fixture->setLikelihood('My Title');
        $fixture->setImpact('My Title');
        $fixture->setMitigationMeasures('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/risk/');
    }
}
