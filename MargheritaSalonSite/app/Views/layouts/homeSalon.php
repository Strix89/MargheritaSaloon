<!DOCTYPE html>
<html lang="it">
    <?= view("templates/head", ['title' => $title]) ?>
	<body>
        <?= view("templates/header") ?>
        <?= view("templates/slides") ?>
        <div class="works">
            <div class="works-text">
                <p>Ecco il nostro lavoro..</p>
            </div>
            <div class="works-slider">
                <img class="active" src="Images/Works/work_1.jpg" alt="work_1.jpg">
                <img src="Images/Works/work_2.jpg" alt="work_2.jpg">
                <img src="Images/Works/work_3.jpg" alt="work_3.jpg">
            </div>
            <div class="works-buttons">
                <button class="slider-works-button active">1</button>
                <button class="slider-works-button ">2</button>
                <button class="slider-works-button ">3</button>
            </div>
        </div>
        <script>
            const slider = document.querySelector(".works-slider");
            const images = slider.querySelectorAll("img");
            const buttons = document.querySelectorAll(".slider-works-button");
            
            let currentImage = 0;
            
            function showImage(index){
                images.forEach(image => image.classList.remove("active"));
                buttons.forEach(button => button.classList.remove("active"));
                images[index].classList.add("active");
                buttons[index].classList.add("active");
            }
            
            buttons.forEach((button, index) => {
                button.addEventListener("click", () => {
                    currentImage = index;
                    showImage(currentImage);
                });
            })
            
            showImage(currentImage);
        </script>
        <div class="products">
            <div class="products-text">
                <h2>Prodotti disponibili:</h2>
                <p>Presso la nostra sede troverai i migliori beauty products sul mercato.<br>Registrati per sapere i prezzi e vedere le descrizioni.</p>
            </div>
            <div class="products-images">
                <div class="product-image">
                    <img src="Images/Products/product_1.jpg" alt="product_1.jpg">
                </div>
                <div class="product-image">
                    <img src="Images/Products/product_2.jpg" alt="product_2.jpg">
                </div>
                <div class="product-image">
                    <img src="Images/Products/product_3.jpg" alt="product_3.jpg">
                </div>
                <div class="product-image">
                    <img src="Images/Products/product_4.jpg" alt="product_4.jpg">
                </div>
                <div class="product-image">
                    <img src="Images/Products/product_5.jpg" alt="product_5.jpg">
                </div>
                <div class="product-image">
                    <img src="Images/Products/product_6.jpg" alt="product_6.jpg">
                </div>
            </div>
        </div>
        <div class="reviews">
            <div class="rev-slider">
                <div class="rev-slide active">
                    <h2>Cristina Tolve</h2>
                    <h3>22/02/2023</h3>
                    <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur."</p>
                </div>
                <div class="rev-slide">
                    <h2>Roberta Torna</h2>
                    <h3>14/02/2023</h3>
                    <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur."</p>
                </div>
                <div class="rev-slide">
                    <h2>Laura Retta</h2>
                    <h3>11/02/2023</h3>
                    <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur."</p>
                </div>
            </div>
            <div class="rev-slider-arrows">
                <button class="slide-arrow prev">&lt;</button>
                <button class="slide-arrow next">&gt;</button>
            </div>
        </div>
        <script>
            const revSlider = document.querySelector(".rev-slider");
            const revSlides = revSlider.querySelectorAll(".rev-slide");
            const prevArrow = document.querySelector(".rev-slider-arrows").querySelector(".prev");
            const nextArrow = document.querySelector(".rev-slider-arrows").querySelector(".next");

            let currentRev = 0;

            function showRev(index){
                revSlides.forEach(rev => rev.classList.remove("active"));
                revSlides[index].classList.add("active");
            }

            prevArrow.addEventListener("click", () => {
                currentRev--;
                if(currentRev < 0){
                    currentRev = revSlides.length - 1;
                }
                showRev(currentRev);
            });

            nextArrow.addEventListener("click", () => {
                currentRev++;
                if(currentRev > revSlides.length - 1){
                    currentRev = 0;
                }
                showRev(currentRev);
            });

            showRev(currentRev);
        </script>
        <?= view("templates/footer.php"); ?>
    </body>
</html>