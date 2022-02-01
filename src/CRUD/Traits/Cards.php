<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Traits;

trait Cards {

    protected static $cardKeys = [
        'card_class' => '',
        'header_class' => '',
        'body_class' => '',
    ];
    protected static $cards = [];

    public static function addCard ($cardId, $cardName, $data) {
        $data['name'] = $cardName;

        self::$cards[$cardId] = self::$cardKeys;
        foreach($data as $key => $value) {
            self::$cards[$cardId][$key] = $value;
        }
    }

    public static function getCards($fields = []): array {

        if(!is_array($fields) || count($fields) == 0) {
            return self::$cards;
        }

        $cards = [];
        foreach(self::$cards as $cardId => $cardData) {

            $cardData['fields'] = [];

            foreach($fields as $fieldName => $fieldData) {
                if(isset($fieldData['card']) && $fieldData['card'] != '') {

                    if($fieldData['card'] == $cardId) {
                        $cardData['fields'][$fieldName] = $fieldData;
                    }

                }
            }

            $cards[$cardId] = $cardData;
        }

        return $cards;
    }

    public static function setCards(array $cards): void {
        self::$cards = $cards;
    }
}