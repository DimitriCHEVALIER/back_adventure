<?php

namespace App\Service;

use App\Dto\CoinDto;
use App\Entity\Cryptocurrency;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CoinGeckoService
{
    private $entityManager;
    private $client;

    public function __construct(EntityManagerInterface $entityManager, HttpClientInterface $client)
    {
        $this->entityManager = $entityManager;
        $this->client = $client;
    }

    public function getListIdCoins()
    {
        $response = $this->client->request(
            'GET',
            'https://api.coingecko.com/api/v3/coins/list?include_platform=true'
        );

        $tabAllCoins = json_decode($response->getContent());

        $allCoinsInDatabase = $this->entityManager->getRepository(Cryptocurrency::class)->findAll();

        $arrayFilledCoins = [];

        $coinsToQuery = '';
        /** @var Cryptocurrency $coinDatabase */
        foreach ($allCoinsInDatabase as $coinDatabase) {
            $key = '';
            if (!$coinDatabase->getNameForGeckoFetch()) {
                $key = array_search(strtolower($coinDatabase->getCode()), array_column($tabAllCoins, 'symbol'));
            } else {
                $key = array_search($coinDatabase->getNameForGeckoFetch(), array_column($tabAllCoins, 'name'));
            }
            if ($key) {
                $coinsToQuery = $coinsToQuery.$tabAllCoins[$key]->id.',';
                $coinDto = new CoinDto();
                $coinDto->setCode($coinDatabase->getCode());
                $coinDto->setNom($coinDatabase->getName());
                $coinDto->setId($tabAllCoins[$key]->id);
                array_push($arrayFilledCoins, $coinDto);
            }
        }
        $coinsToQuery = substr($coinsToQuery, 0, -1);
        $response = $this->client->request(
            'GET',
            'https://api.coingecko.com/api/v3/simple/price?ids='.$coinsToQuery.'&vs_currencies=eur'
        );

        $tabAllCoinsValue = json_decode(json_encode(json_decode($response->getContent())), true);

        /** @var CoinDto $filledCoin */
        foreach ($arrayFilledCoins as $filledCoin) {
            if (key_exists($filledCoin->getId(), $tabAllCoinsValue)) {
                $filledCoin->setValue($tabAllCoinsValue[$filledCoin->getId()]['eur']);
            }
        }

        return $arrayFilledCoins;
    }
}
