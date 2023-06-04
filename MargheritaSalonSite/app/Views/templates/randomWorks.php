        <div class="works">
            <div class="works-text">
                <p>Ecco il nostro lavoro..</p>
            </div>
            <div class="works-slider">
                <?php for($i = 0; $i < count($works_images); $i++): ?>
                    <?php if($i == 0) : ?>
                        <img class="active" src="assets/works/<?= $works_images[$i] ?>" alt="work_<?= $i ?>.jpg">
                    <?php else: ?>
                        <img src="assets/works/<?= $works_images[$i] ?>" alt="work_<?= $i ?>.jpg">
                    <?php endif; ?>
                <?php endfor; ?>
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