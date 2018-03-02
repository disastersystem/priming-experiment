let compressionType = '2_JPEG_Compression'
let images = [
    [
        // purple flower wall
        'final01_d2_l1.bmp',
        'final01_d2_l2.bmp',
        'final01_d2_l3.bmp',
        'final01_d2_l4.bmp',
        'final01_d2_l5.bmp'
    ], [
        // two circle lamps
        'final02_d2_l1.bmp',
        'final02_d2_l2.bmp',
        'final02_d2_l3.bmp',
        'final02_d2_l4.bmp',
        'final02_d2_l5.bmp'
    ], [
        // red winter barn
        'final07_d2_l1.bmp',
        'final07_d2_l2.bmp',
        'final07_d2_l3.bmp',
        'final07_d2_l4.bmp',
        'final07_d2_l5.bmp'
    ]
]

// get a random integer between 0 and the length of the images array
let randSetNum = getRandomInt(0, images.length)
let randImageNum = getRandomInt(0, images[randSetNum].length)

let path = 'images/CIDIQ/images/reproduction/' + compressionType + '/' + images[randSetNum][randImageNum]

document.querySelector('.image').src = path


Array.from(document.querySelectorAll('.rate__btn')).forEach(function(item, v) {
    item.addEventListener('click', function (evt) {
        evt.preventDefault()

        submitResults(this.innerText)

        // get a random integer between 0 and the length of the images array
        let randSetNum = getRandomSet()
        let randImageNum = getRandomInt(0, images[randSetNum].length)

        let path = 'images/CIDIQ/images/reproduction/' + compressionType + '/' + images[randSetNum][randImageNum]

        document.querySelector('.image').src = path
    })
})

function submitResults(answer) {
    console.log(answer)
}

function getRandomSet() {
    return getRandomInt(0, images.length)
}

function getRandomImage() {
    return getRandomInt(0, images[randSetNum].length)
}