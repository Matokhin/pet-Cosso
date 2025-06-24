<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if (!empty($arResult["ERRORS"])): ?>
    <div class="alert alert-danger">
        <?php foreach ($arResult["ERRORS"] as $error): ?>
            <p><?= htmlspecialcharsbx($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="container my-4">
    <h2 class="mb-4">Корзина</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-light">
        <tr>
            <th>Название</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Итого</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($arResult["ITEMS"] as $item): ?>
            <tr>
                <td><?= htmlspecialcharsbx($item["NAME"]) ?></td>
                <td><?= number_format($item["PRICE"], 2, '.', ' ') ?> ₽</td>
                <td><?= $item["QUANTITY"] ?></td>
                <td><?= number_format($item["TOTAL"], 2, '.', ' ') ?> ₽</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <p class="fw-bold">Общая сумма: <?= number_format($arResult["TOTAL"], 2, '.', ' ') ?> ₽</p>

    <h2 class="mt-5">Оформление заказа</h2>
    <form method="POST" class="mt-3">
        <div class="mb-3">
            <label for="order-name" class="form-label">Имя:</label>
            <input type="text" name="name" id="order-name" class="form-control" required>
        </div>
        <br>
        <div class="mb-3">
            <label for="order-phone" class="form-label">Телефон:</label>
            <input type="text" name="phone" id="order-phone" class="form-control" required>
        </div>
        <br>
        <div class="mb-3">
            <label for="order-delivery" class="form-label">Способ доставки:</label>
            <select name="delivery_id" id="order-delivery" class="form-select">
                <?php foreach ($arResult['DELIVERY_LIST'] as $delivery): ?>
                    <option value="<?= $delivery['ID'] ?>"><?= htmlspecialcharsbx($delivery['NAME']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <br>
        <div class="mb-4">
            <label for="order-payment" class="form-label">Способ оплаты:</label>
            <select name="paysystem_id" id="order-payment" class="form-select">
                <?php foreach ($arResult['PAYSYSTEM_LIST'] as $paySystem): ?>
                    <option value="<?= $paySystem['ID'] ?>"><?= htmlspecialcharsbx($paySystem['NAME']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <br>
        <input type="hidden" name="submit_order" value="Y">
        <button type="submit" class="btn btn-primary">Оформить заказ</button>
    </form>
</div>
