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
            'https://api.coingecko.com/api/v3/coins/markets?vs_currency=eur&ids='.$coinsToQuery.'&order=market_cap_desc&per_page=100&page=1&sparkline=true'
        );

        $tabAllCoinsValue = json_decode(json_encode(json_decode($response->getContent())), true);

        /** @var CoinDto $filledCoin */
        foreach ($arrayFilledCoins as $filledCoin) {
            $relatedCoin = $this->getValueInGeckoList($tabAllCoinsValue, $filledCoin->getId());
            if ($relatedCoin) {
                $filledCoin->setValue($relatedCoin['current_price']);
                $filledCoin->setDateDebutChart($relatedCoin['last_updated']);
                $filledCoin->setSparklingLastWeek($relatedCoin['sparkline_in_7d']['price']);
                $filledCoin->setImgSrc($relatedCoin['image']);
            }
        }

        return $arrayFilledCoins;
    }

    private function getValueInGeckoList($list, $id): ?array
    {
        foreach ($list as $coin) {
            if (key_exists('id', $coin) && $coin['id'] === $id) {
                return $coin;
            }
        }

        return null;
    }
}
