<?php

namespace App\Tests\Entity;

use App\Entity\Taxe;
use App\Entity\Produit;

use App\Repository\ProduitRepository;
use App\Tests\Utils\ValidatorTestTrait;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;


class ProduitEntityTest extends KernelTestCase
{
    use ValidatorTestTrait;

    private $databaseTool;

    public function setUp(): void
    {
        parent::setUp();

        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function testRepositoryCount(): void
    {
        $this->databaseTool->loadAliceFixture([
            \dirname(__DIR__) . '/Fixtures/ProduitFixtures.yaml'
        ]);

        $produits = self::getContainer()->get(ProduitRepository::class)->count([]);

        $this->assertEquals(20, $produits);
    }

    /**
     * Undocumented function
     *
     * @param UploadedFile $image
     * @param string $taxe
     * @return Produit
     */
    private function getEntity(): Produit
    {
        $taxe = (new Taxe)
            ->setName('TVA 15%')
            ->setEnable(true)
            ->setRate(0.15);

        $image = new Image(\dirname(__DIR__) . 'tests\Entity\Images\symfony.jpeg');

        return (new Produit)
            ->setTitle('Produit Test')
            ->setShortDescription(str_repeat('a', 100))
            ->setPriceHT(199.99)
            ->setImage($image)
            ->setTaxe($taxe)
            ->setEnable(true);
    }

    public function testValideEntity(): void
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    /**
     * @dataProvider  provideTitle
     *
     * @param string $title
     * @param integer $numberError
     * @return void
     */
    public function testInvalideTitle(string $title, int $numberError): void
    {
        $produit = $this->getEntity()
            ->setTitle($title);

        $this->assertHasErrors($produit, $numberError);
    }

    public function provideTitle(): array
    {
        return [
            'unique' => [
                'title' => 'Produit 1',
                'numberError' => 1,
            ],
            'maxLength' => [
                'title' => str_repeat('a', 256),
                'numberError' => 1,
            ],
            'notBlank' => [
                'title' => '',
                'numberError' => 1,
            ],
        ];
    }
}
