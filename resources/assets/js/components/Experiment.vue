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
                    <!-- <fullscreen-button @show="fullscreen"></fullscreen-button> -->
                </div>
            </div>

            <div class="image-container">
                <!-- <transition name="modal"> -->
                    <img class="image" :src="path">
                <!-- </transition> -->
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
    import getRandomInt from '../core/functions/random'
    import Fullscreen from '../core/classes/Fullscreen'
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

                fullscreen: false,

                fullsc: new Fullscreen,

                imageSet: 0,

                traningImages: [],

                order: 0,

                count: 0
            }
        },

        components: {
            modal
        },

        methods: {
            submitAnswer(rating) {
                let vm = this

                var answ = {
                    answer: rating,
                    image: this.path,
                    subject: window.localStorage.getItem('id')
                }
                
                this.results++

                if (this.results > 5) { // do not save the first 5 images
                    axios.post('answer/store', answ).then(function (response) {
                        if (response.data == 'saved') {
                            
                            if (vm.results == vm.total) {
                                vm.modal.header = 'You have completed ' + vm.total + ' images!'
                                vm.modal.message = `
                                    It would be greatly appreciated if you would do even more.
                                    You can quit at any time by simply closing the browser tab!'
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
                } else {
                    vm.changeImage()
                }
            },

            changeImage() {
                if (this.results % 5 === 0) {
                    this.imageSet = getRandomInt(0, this.images.length)
                    
                    this.order = _.shuffle( [0, 1, 2, 3, 4] )

                    this.count = 0
                }

                var randImageNum = this.order[this.count];
                // console.log(this.order)
                // console.log(this.order[0]);
                // console.log(this.order[1]);
                // console.log(this.order[2]);
                // console.log(this.order[3]);
                // console.log(this.order[4]);
                // console.log(this.order[this.count]);

                // let randImageNum = getRandomInt(0, this.images[this.imageSet].length)

                this.path = this.folder + this.compressionType + '/' + this.images[this.imageSet][randImageNum]

                this.count++
            },

            showInfo() {
                this.modal.header = 'About'
                this.modal.message = `
                    <h3 style="margin-bottom: 0;">Rate the quality of the image by selecting one of the 5 categories.<br></h3>
                    <p style="margin-top: 5px; padding-top: 0;">The first 5 images are training images and will not count.</p>
                    
                    <p style="margin-bottom: 0; padding-bottom: 0; font-size: 15px;">It would be beneficial if</p>
                    <ul style="margin-top: 0; font-size: 15px;">
                        <!-- <li>You turn up the brightness of your screen as high as possible.</li> -->
                        <li>You enter full screen mode in your browser by hitting the button in the top right corner.</li>
                    </ul>
                `
                this.modal.show = true
            },

            goFullscreen() {
                if (this.fullscreen == false) {
                    this.fullsc.launch(document.documentElement)
                    this.fullscreen = true
                } else {
                    this.fullsc.exit()
                    this.fullscreen = false
                }
            }

        },

        mounted() {
            this.images = data.images

            this.imageSet = getRandomInt(0, this.images.length)

            this.order = _.shuffle( [0, 1, 2, 3, 4] )

            this.path = this.folder + this.compressionType + '/' + this.images[this.imageSet][this.order[0]]

            if ( window.localStorage.getItem('id') === null ) {
                axios.post('subject/store').then(function (response) {
                    window.localStorage.setItem('id', response.data)
                })
            }

            this.modal.header = 'Thank you for participating in this experiment!'
            this.modal.message = `
                <h3 style="margin-bottom: 0;">Rate the quality of the image by selecting one of the 5 categories.<br></h3>
                <p style="margin-top: 5px; padding-top: 0;">The first 5 images are training images and will not count.</p>
                
                <p style="margin-bottom: 0; padding-bottom: 0; font-size: 15px; margin-top: 30px;">It would be beneficial if</p>
                <ul style="margin-top: 0; font-size: 15px;">
                    <!-- <li>You turn up the brightness of your screen as high as possible.</li> -->
                    <li>You enter full screen mode in your browser by hitting the button in the top right corner.</li>
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