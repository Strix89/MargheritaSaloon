        <div class="reviews">
            <div class="rev-slider">
                <?php for($i = 0; $i < count($reviews); $i++): ?>
                    <?php if($i === 0) : ?>
                        <div class="rev-slide active">
                    <?php else: ?>
                        <div class="rev-slide">
                    <?php endif; ?>
                            <h2> <?= $reviews[$i]->Nome . " " . $reviews[$i]->Cognome ?></h2>
                            <h3> <?= $reviews[$i]->Data ?> </h3>
                            <p>" <?= $reviews[$i]->Testo ?> "</p>
                        </div>
                <?php endfor; ?>
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