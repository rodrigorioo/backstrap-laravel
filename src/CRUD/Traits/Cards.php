<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Traits;

use Rodrigorioo\BackStrapLaravel\CRUD\Classes\Card;

trait Cards {

    public function getCards() : array {
        return $this->cards;
    }

    public function setCards(array $setCards) : void {

        $cards = $this->getCards();

        foreach($setCards as $setCardId => $setCard) {

            if(isset($fields[$setCardId])) {

                foreach($setCard as $dataName => $dataValue) {

                    switch($dataName) {
                        case 'card_class': $cards[$setCardId]->setCardClass($dataValue); break;
                        case 'header_class': $cards[$setCardId]->setHeaderClass($dataValue); break;
                        case 'body_class': $cards[$setCardId]->setBodyClass($dataValue); break;
                    }
                }

            } else {
                $cards[$setCardId] = $this->createCardClass(
                    $setCardId,
                    $setCard['name'],
                    (isset($setCard['card_class'])) ? $setCard['card_class'] : '',
                    (isset($setCard['header_class'])) ? $setCard['header_class'] : '',
                    (isset($setCard['body_class'])) ? $setCard['body_class'] : '',
                );
            }

        }

        $this->cards = $cards;
    }

    public function deleteCard($cardId) {
        unset($this->cards[$cardId]);
    }

    public function createCardClass($cardId, $cardName, $cardClass = '', $headerClass = '', $bodyClass = '') : Card {
        return new Card($cardId, $cardName, $cardClass, $headerClass, $bodyClass);
    }

    public function createCard ($cardId, $cardName, $cardClass = '', $headerClass = '', $bodyClass = '') {
        $this->cards[$cardId] = $this->createCardClass($cardId, $cardName, $cardClass, $headerClass, $bodyClass);
    }
}