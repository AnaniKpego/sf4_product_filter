
require('../css/app.css');


//console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

import noUiSlider from 'nouislider'
import 'nouislider/distribute/nouislider.css'
const slider = document.getElementById('slider-price');

if (slider){
    const min = document.getElementById('min')
    const max = document.getElementById('max')
    const minValue = Math.floor(parseInt(slider.dataset.min, 10)/10)*10
    const maxValue = Math.ceil(parseInt(slider.dataset.max, 10)/10)*10
   const rang =  noUiSlider.create(slider, {
        start: [min.value || minValue, max.value || maxValue],
        connect: true,
        step:10,
        range: {
            'min': minValue,
            'max': maxValue
        }
    })

    rang.on('slide', function (values, handle) {
        if (handle ===0){
            min.value = Math.round(values[0])
        }
        if (handle ===1 ){
            max.value = Math.round(values[1])
        }
        console.log(values, handle)
    })
}

