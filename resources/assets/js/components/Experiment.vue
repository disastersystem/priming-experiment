<template>
    <div>
        <div class="flex-center position-ref full-height">
            <div class="top-bar">
                <button @click="showInfo()" class="info__btn" title="Information">
                    <img src="icons/info.png" style="width: 25px;">
                </button>
                
                <div style="display: flex; align-items: center;">
                    <span>{{ results }} / {{ total }}</span>

                    <button @click="goFullscreen()" class="fullscreen__btn" title="Fullscreen mode">
                        <img src="icons/fullscreen.png" style="width: 25px;">
                    </button>
                </div>
            </div>

            <div class="image-container">
                <img class="image" :src="path">
            </div>

            <div class="rating-bar">
                <button class="rate__btn" @click="submitAnswer('bad')">Bad</button>
                <button class="rate__btn" @click="submitAnswer('poor')">Poor</button>
                <button class="rate__btn" @click="submitAnswer('fair')">Fair</button>
                <button class="rate__btn" @click="submitAnswer('good')">Good</button>
                <button class="rate__btn" @click="submitAnswer('excellent')">Excellent</button>
            </div>
        </div>

        <modal v-if="modal.show" @close="modal.show = false">
            <h3 slot="header" v-html="modal.header"></h3>

            <div slot="body" v-html="modal.message"></div>
        </modal>
    </div>
</template>

<script>
    import data from '../data'
    import modal from '../components/Modal'

    export default {
        data() {
            return {
                images: [],
                path: '',
                folder: 'images/CIDIQ/Images/Reproduction/',
                compressionType: '2_JPEG_Compression',

                // answers: [],
                results: 0,
                total: 100,

                modal: {
                    show: false,
                    message: '',
                    header: ''
                },

                fullscreen: false
            }
        },

        components: {
            modal
        },

        methods: {
            getRandomInt(min, max) {
                min = Math.ceil(min)
                max = Math.floor(max)

                //the maximum is exclusive and the minimum is inclusive
                return Math.floor(Math.random() * (max - min)) + min
            },

            submitAnswer(rating) {
                let vm = this

                var answ = {
                    answer: rating,
                    image: this.path,
                    subject: window.localStorage.getItem('id')
                }
                
                this.results++

                if (this.results > 3) { // do not save the first 3 images
                    axios.post('answer/store', answ).then(function (response) {
                        if (response.data == 'saved') {
                            
                            if (vm.results == vm.total) {
                                vm.modal.header = 'You have completed ' + vm.total + ' images!'
                                vm.modal.message = `
                                    It would be greatly appreciated if you would do even more.
                                    You can quit at any time, by simply closing the browser tab!'
                                `
                                vm.modal.show = true
                                vm.total += 50

                                vm.changeImage()
                            } else {
                                vm.changeImage()
                            }
                        }
                    }).catch(function (error) {
                        console.log(error)
                    })
                }
            },

            changeImage() {
                let randSetNum = this.getRandomInt(0, this.images.length)
                let randImageNum = this.getRandomInt(0, this.images[randSetNum].length)

                this.path = this.folder + this.compressionType + '/' + this.images[randSetNum][randImageNum]
            },

            showInfo() {
                this.modal.header = 'About'
                this.modal.message = `
                    <h3 style="margin-bottom: 0;">Rate the quality of the image by selecting one of the 5 categories.<br></h3>
                    <p style="margin-top: 5px; padding-top: 0;">The first 3 images are training images and will not count.</p>
                    
                    <p style="margin-bottom: 0; padding-bottom: 0; font-size: 15px;">It would be beneficial if</p>
                    <ul style="margin-top: 0; font-size: 15px;">
                        <li>You turn up the brightness of your screen as high as possible.</li>
                        <li>Enter full screen mode in your browser by hitting the button in the top right corner.</li>
                    </ul>
                `
                this.modal.show = true
            },

            goFullscreen() {
                if (this.fullscreen == false) {
                    var elem = document.documentElement

                    if (elem.requestFullscreen) {
                        elem.requestFullscreen()
                    } else if (elem.msRequestFullscreen) {
                        elem.msRequestFullscreen()
                    } else if (elem.mozRequestFullScreen) {
                        elem.mozRequestFullScreen()
                    } else if (elem.webkitRequestFullscreen) {
                        elem.webkitRequestFullscreen()
                    }

                    this.fullscreen = true
                } else {
                    if (document.exitFullscreen) {
                        document.exitFullscreen()
                    } else if (document.mozCancelFullScreen) {
                        document.mozCancelFullScreen()
                    } else if (document.webkitExitFullscreen) {
                        document.webkitExitFullscreen()
                    }

                    this.fullscreen = false
                }
            }

        },

        mounted() {
            this.images = data.images

            let randSetNum = this.getRandomInt(0, this.images.length)
            let randImageNum = this.getRandomInt(0, this.images[randSetNum].length)

            this.path = this.folder + this.compressionType + '/' + this.images[randSetNum][randImageNum]

            if ( window.localStorage.getItem('id') === null ) {
                axios.post('subject/store').then(function (response) {
                    window.localStorage.setItem('id', response.data)
                })
            }

            this.modal.header = 'Thanks for participating in this experiment!'
            this.modal.message = `
                <h3 style="margin-bottom: 0;">Rate the quality of the image by selecting one of the 5 categories.<br></h3>
                <p style="margin-top: 5px; padding-top: 0;">The first 3 images are training images and will not count.</p>
                
                <p style="margin-bottom: 0; padding-bottom: 0; font-size: 15px; margin-top: 30px;">It would be beneficial if</p>
                <ul style="margin-top: 0; font-size: 15px;">
                    <li>You turn up the brightness of your screen as high as possible.</li>
                    <li>Enter full screen mode in your browser by hitting the button in the top right corner.</li>
                </ul>
            `
            this.modal.show = true
        }
    }
</script>

<style scoped>
    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #000;
        font-weight: bold;
        padding: 20px;
        position: fixed;
        top: 0;
        right: 0;
        /*width: 50%;*/
        left: 0;
        z-index: 10;
    }

    .info__btn {
        padding: 2px;
        font-weight: bold;
        background-color: #e1e1e1;
        border: none;
        outline: 0;
        cursor: pointer;
    }

    .fullscreen__btn {
        padding: 2px;
        font-weight: bold;
        background-color: #e1e1e1;
        border: none;
        outline: 0;
        cursor: pointer;
        margin-left: 40px;
    }

    .rating-bar {
        position: fixed;
        bottom: 0;
        padding: 30px;
        z-index: 10;
    }
</style>