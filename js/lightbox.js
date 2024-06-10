console.log("le fichier lightbox.js fonctionne");

document.addEventListener('DOMContentLoaded', function() {
    fetch('/wp-json/custom/v1/load-slider-photos')
        .then(response => response.json())
        .then(slides => {
            if (slides.length > 0) {
                let currentSlideIndex = 0;

                function changeSlide(sens) {
                    let newIndex = currentSlideIndex + sens;

                    if (newIndex < 0) {
                        currentSlideIndex = slides.length - 1;
                    } else if (newIndex >= slides.length) {
                        currentSlideIndex = 0;
                    } else {
                        currentSlideIndex = newIndex;
                    }

                    document.querySelector(".banner-img").src = slides[currentSlideIndex].image;
                    document.getElementById("text").innerHTML = slides[currentSlideIndex].title;
                }

                const clicArrowLeft = document.querySelector(".arrow_left");
                const clicArrowRight = document.querySelector(".arrow_right");

                clicArrowLeft.addEventListener("click", function() {
                    const nbreDots = document.querySelectorAll(".dot");
                    const slideActive = document.querySelector(".dot_selected");

                    let selectedIndex;
                    for (let i = 0; i < nbreDots.length; i++) {
                        if (nbreDots[i] === slideActive) {
                            selectedIndex = i;
                            break;
                        }
                    }

                    const newSelectedIndex = (selectedIndex - 1 + nbreDots.length) % nbreDots.length;
                    slideActive.classList.remove("dot_selected");
                    nbreDots[newSelectedIndex].classList.add("dot_selected");

                    changeSlide(-1);
                });

                clicArrowRight.addEventListener("click", function() {
                    const nbreDots = document.querySelectorAll(".dot");
                    const slideActive = document.querySelector(".dot_selected");

                    let selectedIndex;
                    for (let i = 0; i < nbreDots.length; i++) {
                        if (nbreDots[i] === slideActive) {
                            selectedIndex = i;
                            break;
                        }
                    }

                    const newSelectedIndex = (selectedIndex + 1) % nbreDots.length;
                    slideActive.classList.remove("dot_selected");
                    nbreDots[newSelectedIndex].classList.add("dot_selected");

                    changeSlide(1);
                });

                const div_dots = document.querySelector("#banner .dots");

                for (let i = 0; i < slides.length; i++) {
                    const dot = document.createElement("p");
                    dot.classList.add("dot");
                    if (i === 0) {
                        dot.classList.add("dot_selected");
                    }
                    div_dots.appendChild(dot);
                }

                // Initialiser la première slide
                document.querySelector(".banner-img").src = slides[0].image;
                document.getElementById("text").innerHTML = slides[0].title;
            }
        });
});