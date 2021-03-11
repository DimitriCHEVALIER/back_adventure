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

        $arrayReturnValues = [];
        /** @var Cryptocurrency $coinDatabase */
        foreach ($allCoinsInDatabase as $coinDatabase) {
            $key = '';
            if (!$coinDatabase->getNameForGeckoFetch()) {
                $key = array_search(strtolower($coinDatabase->getCode()), array_column($tabAllCoins, 'symbol'));
            } else {
                $key = array_search($coinDatabase->getNameForGeckoFetch(), array_column($tabAllCoins, 'name'));
            }
            if ($key) {
                $responseCoin = $this->client->request(
                    'GET',
                    'https://api.coingecko.com/api/v3/coins/'.$tabAllCoins[$key]->id.'?tickers=false&market_data=true&community_data=false&developer_data=false&sparkline=false'
                );
                $responseCoin = json_decode($responseCoin->getContent());
                if (property_exists($responseCoin, 'market_data') && property_exists($responseCoin->market_data, 'current_price')
                    && property_exists($responseCoin->market_data->current_price, 'eur')) {
                    $coinDto = new CoinDto();
                    $coinDto->setValue($responseCoin->market_data->current_price->eur);
                    $coinDto->setNom($coinDatabase->getName());
                    $coinDto->setCode($coinDatabase->getCode());
                    array_push($arrayReturnValues, $coinDto);
                }
            }
        }

        return $arrayReturnValues;
    }
}
