'use strict'

function getRandomInt(min, max) {
    min = Math.ceil(min)
    max = Math.floor(max)

    //the maximum is exclusive and the minimum is inclusive
    return Math.floor(Math.random() * (max - min)) + min
}

export default getRandomInt