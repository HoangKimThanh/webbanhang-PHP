const sliderImgs = s('.slider-imgs img');
const sliderDots = s('.slider-dot');

var x = 0;
var slide = () => {
    let y = x;
    sliderImgs.forEach((sliderImg, index) => {
        sliderImg.style.left = -y*100 + '%';
        
        if (y == 0) {
            a('.slider-dot.slider-dot--active').classList.remove('slider-dot--active');
            sliderDots[index].classList.add('slider-dot--active');
        }
        
        if (index == sliderImgs.length - 1) {
            (x < sliderImgs.length - 1) ? x++ : x = 0;
        }
        y--;
    })
}

slide();

sliderDots.forEach((sliderDot, index) => {
    sliderDot.onclick = () => {
        x = index;
        slide();
    }
})

setInterval(slide, 3000);


