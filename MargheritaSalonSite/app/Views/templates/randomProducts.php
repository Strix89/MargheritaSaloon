<div class="products">
    <div class="products-text">
        <h2>Prodotti disponibili:</h2>
        <p>Presso la nostra sede troverai i migliori beauty products sul mercato.<br>Registrati per sapere i prezzi e vedere le descrizioni.</p>
    </div>
    <div class="products-images">
    <?php foreach($product_images as $image): ?>
        <div class="product-image">
            <img src="assets/products/<?= $image; ?>" alt="<?= $image; ?>">
        </div>
    <?php endforeach; ?>
    </div>
</div>