<?php

namespace Tests\Mocks\AwesomeApi;
trait AwesomeApiMocks
{
    public function getQuotes(): string
    {
        return <<<JSON
            {
                "USDBRL": {
                    "code": "USD",
                    "codein": "BRL",
                    "name": "Dólar Americano/Real Brasileiro",
                    "high": "5.0018",
                    "low": "4.9818",
                    "varBid": "0.0062",
                    "pctChange": "0.12",
                    "bid": "4.9949",
                    "ask": "4.9965",
                    "timestamp": "1710536398",
                    "create_date": "2024-03-15 17:59:58"
                },
                "EURBRL": {
                    "code": "EUR",
                    "codein": "BRL",
                    "name": "Euro/Real Brasileiro",
                    "high": "5.4472",
                    "low": "5.4285",
                    "varBid": "0.0107",
                    "pctChange": "0.2",
                    "bid": "5.4384",
                    "ask": "5.4464",
                    "timestamp": "1710536308",
                    "create_date": "2024-03-15 17:58:28"
                }
            }
        JSON;
    }

    public function coinNotExists(): string
    {
        return <<<JSON
            {
                "status": 404,
                "code": "CoinNotExists",
                "message": "moeda nao encontrada ABC-BRL"
            }
        JSON;
    }

    public function getCoins(): string
    {
        return <<<JSON
              {
                "AED": "Dirham dos Emirados",
                "AFN": "Afghani do Afeganistão",
                "ALL": "Lek Albanês",
                "AMD": "Dram Armênio",
                "ANG": "Guilder das Antilhas",
                "AOA": "Kwanza Angolano",
                "ARS": "Peso Argentino",
                "AUD": "Dólar Australiano",
                "BND": "Dólar de Brunei",
                "BOB": "Boliviano",
                "BRL": "Real Brasileiro",
                "BRLT": "Real Brasileiro Turismo",
                "BSD": "Dólar das Bahamas",
                "BTC": "Bitcoin"
            }
        JSON;
    }

    public function quoteAvailable()
    {
        return <<<JSON
            {
                "USD-BRL": "Dólar Americano/Real Brasileiro",
                "USD-BRLT": "Dólar Americano/Real Brasileiro Turismo",
                "CAD-BRL": "Dólar Canadense/Real Brasileiro",
                "EUR-BRL": "Euro/Real Brasileiro",
                "GBP-BRL": "Libra Esterlina/Real Brasileiro",
                "ARS-BRL": "Peso Argentino/Real Brasileiro",
                "BTC-BRL": "Bitcoin/Real Brasileiro",
                "LTC-BRL": "Litecoin/Real Brasileiro",
                "JPY-BRL": "Iene Japonês/Real Brasileiro",
                "USD-ZWL": "Dólar Americano/Dólar Zimbabuense",
                "BRL-ARS": "Real Brasileiro/Peso Argentino",
                "BRL-AUD": "Real Brasileiro/Dólar Australiano",
                "BRL-CAD": "Real Brasileiro/Dólar Canadense",
                "BRL-CHF": "Real Brasileiro/Franco Suíço",
                "BRL-CLP": "Real Brasileiro/Peso Chileno",
                "BRL-DKK": "Real Brasileiro/Coroa Dinamarquesa",
                "BRL-HKD": "Real Brasileiro/Dólar de Hong Kong",
                "BRL-JPY": "Real Brasileiro/Iene Japonês",
                "BRL-MXN": "Real Brasileiro/Peso Mexicano",
                "BRL-SGD": "Real Brasileiro/Dólar de Cingapura",
                "SGD-BRL": "Dólar de Cingapura/Real Brasileiro",
                "AED-BRL": "Dirham dos Emirados/Real Brasileiro",
                "BRL-AED": "Real Brasileiro/Dirham dos Emirados",
                "BRL-BBD": "Real Brasileiro/Dólar de Barbados",
                "BRL-BHD": "Real Brasileiro/Dinar do Bahrein",
                "BRL-CNY": "Real Brasileiro/Yuan Chinês",
                "BRL-CZK": "Real Brasileiro/Coroa Checa",
                "BRL-EGP": "Real Brasileiro/Libra Egípcia",
                "BRL-GBP": "Real Brasileiro/Libra Esterlina",
                "BRL-HUF": "Real Brasileiro/Florim Húngaro",
                "BRL-IDR": "Real Brasileiro/Rupia Indonésia",
                "BRL-ILS": "Real Brasileiro/Novo Shekel Israelense"
            }
        JSON;
    }

    public function getQuoteSelectCoin($from, $to): string
    {
        return <<<JSON
            {
                "$from$to": {
                    "code": "$from",
                    "codein": "$to",
                    "name": "Dólar Americano/Real Brasileiro",
                    "high": "5.0018",
                    "low": "4.9818",
                    "varBid": "0.0062",
                    "pctChange": "0.12",
                    "bid": "4.9949",
                    "ask": "4.9965",
                    "timestamp": "1710536398",
                    "create_date": "2024-03-15 17:59:58"
                }
            }
        JSON;
    }

}
