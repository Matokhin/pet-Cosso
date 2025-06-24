<?php

use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Bitrix\Sale;
use Bitrix\Main\Application;
use Bitrix\Sale\Delivery\Services\Manager as DeliveryManager;
use Bitrix\Sale\PaySystem\Manager as PaySystemManager;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class MyOrderFormComponent extends CBitrixComponent
{
    public function executeComponent()
    {
        if (!Loader::includeModule("sale") || !Loader::includeModule("catalog")) {
            ShowError("Не удалось подключить модули sale и catalog");
            return;
        }

        global $USER;
        $request = Context::getCurrent()->getRequest();

        $fUserId = Sale\Fuser::getId();
        $basket = Sale\Basket::loadItemsForFUser($fUserId, SITE_ID);

        $this->arResult["ITEMS"] = [];
        $totalPrice = 0;
        foreach ($basket as $basketItem) {
            $this->arResult["ITEMS"][] = [
                "NAME" => $basketItem->getField("NAME"),
                "PRICE" => $basketItem->getPrice(),
                "QUANTITY" => $basketItem->getQuantity(),
                "TOTAL" => $basketItem->getFinalPrice(),
            ];
            $totalPrice += $basketItem->getFinalPrice();
        }
        $this->arResult["TOTAL"] = $totalPrice;

        $this->arResult["ERRORS"] = [];

        // Создание временного заказа для определения доставок и платежей
        $dummyOrder = Sale\Order::create(SITE_ID, $USER->IsAuthorized() ? $USER->GetID() : $fUserId);
        $dummyOrder->setPersonTypeId(1);
        $dummyOrder->setBasket($basket);

        // Получение первой доступной службы доставки
        $shipmentCollection = $dummyOrder->getShipmentCollection();
        $shipment = $shipmentCollection->createItem();

        $deliveryServices = DeliveryManager::getRestrictedObjectsList($shipment);
        $this->arResult['DELIVERY_LIST'] = [];
        $deliveryId = 0;
        $deliveryName = '';

        if (!empty($deliveryServices)) {
            foreach ($deliveryServices as $delivery) {
                $this->arResult['DELIVERY_LIST'][] = [
                    'ID' => $delivery->getId(),
                    'NAME' => $delivery->getName()
                ];
            }
            $firstDelivery = reset($deliveryServices);
            $deliveryId = $firstDelivery->getId();
            $deliveryName = $firstDelivery->getName();
        }

        // Получение списка платёжных систем с учётом ограничений
        $paymentCollection = $dummyOrder->getPaymentCollection();
        $payment = $paymentCollection->createItem();

        $paySystems = PaySystemManager::getListWithRestrictions($payment);
        $this->arResult['PAYSYSTEM_LIST'] = [];
        foreach ($paySystems as $paySystem) {
            $this->arResult['PAYSYSTEM_LIST'][] = [
                'ID' => $paySystem['ID'],
                'NAME' => $paySystem['NAME']
            ];
        }

        if ($request->isPost() && $request["submit_order"] === "Y") {
            $name = trim($request["name"]);
            $phone = trim($request["phone"]);
            $deliveryIdInput = (int)$request["delivery_id"];
            $paySystemIdInput = (int)$request["paysystem_id"];

            // Валидация
            if ($name === '') {
                $this->arResult["ERRORS"][] = "Пожалуйста, укажите имя.";
            }

            if ($phone === '') {
                $this->arResult["ERRORS"][] = "Пожалуйста, укажите номер телефона.";
            }

            $availableDeliveryIds = array_column($this->arResult['DELIVERY_LIST'], 'ID');
            if (!in_array($deliveryIdInput, $availableDeliveryIds)) {
                $this->arResult["ERRORS"][] = "Выбран некорректный способ доставки.";
            }

            $availablePaySystemIds = array_column($this->arResult['PAYSYSTEM_LIST'], 'ID');
            if (!in_array($paySystemIdInput, $availablePaySystemIds)) {
                $this->arResult["ERRORS"][] = "Выбран некорректный способ оплаты.";
            }

            // Если есть ошибки — не продолжаем оформление
            if (!empty($this->arResult["ERRORS"])) {
                $this->includeComponentTemplate();
                return;
            }

            $userId = $USER->IsAuthorized() ? $USER->GetID() : Sale\Fuser::getId();

            $order = Sale\Order::create(SITE_ID, $userId);
//            $order->setPersonTypeId(1);
            $order->setBasket($basket);

            $deliveryName = '';
            foreach ($this->arResult['DELIVERY_LIST'] as $delivery) {
                if ((int)$delivery['ID'] === $deliveryIdInput) {
                    $deliveryName = $delivery['NAME'];
                    break;
                }
            }

            $shipmentCollection = $order->getShipmentCollection();
            $shipment = $shipmentCollection->createItem();
            $shipment->setFields([
                'DELIVERY_ID' => $deliveryIdInput,
                'DELIVERY_NAME' => $deliveryName
            ]);

            $paySystemName = '';
            foreach ($this->arResult['PAYSYSTEM_LIST'] as $paySystem) {
                if ((int)$paySystem['ID'] === $paySystemIdInput) {
                    $paySystemName = $paySystem['NAME'];
                    break;
                }
            }

            $paymentCollection = $order->getPaymentCollection();
            $payment = $paymentCollection->createItem();
            $payment->setFields([
                'PAY_SYSTEM_ID' => $paySystemIdInput,
                'PAY_SYSTEM_NAME' => $paySystemName
            ]);

            $order->doFinalAction(true);
            $result = $order->save();

            if (!$result->isSuccess()) {
                $this->arResult["ERRORS"] = $result->getErrorMessages();
            } else {
                LocalRedirect("/order-success/?ORDER_ID=" . $order->getId());
            }
        }

        $this->includeComponentTemplate();
    }
}
