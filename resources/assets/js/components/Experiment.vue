<template>
    <div>
        <div class="flex-center position-ref full-height">
            <div class="top-bar">
                <button @click.prevent="showInstructions" class="info__btn" title="Information">
                    <img src="icons/info.png" style="width: 25px;">
                </button>
                
                <div style="display: flex; align-items: center;">
                    <span>{{ completed }} / {{ total }}</span>

                    <button @click.prevent="onFullscreen()" class="fullscreen__btn" title="Fullscreen mode">
                        <img src="icons/fullscreen.png" style="width: 25px;">
                    </button>

                    <!-- <fullscreen-button @show="fullscreen"></fullscreen-button> -->

                    <button v-if="completed > 3" @click.prevent="onSubmit">
                        {{ completed }} - Finish
                    </button>
                </div>
            </div>

            <div class="image-container">
                <div class="img-box">
                    <transition>
                        <img v-show="isLoad" :src="path" @load="loaded">
                    </transition>

                    <div v-show="!isLoad" class="loading">
                        Loading...
                    </div>
                </div>
            </div>

            <div class="rating-bar">
                <button class="rate__btn" @click="onAnswer(1)" :disabled="!isLoad">
                    Bad
                </button>
                
                <button class="rate__btn" @click="onAnswer(2)" :disabled="!isLoad">
                    Poor
                </button>
                
                <button class="rate__btn" @click="onAnswer(3)" :disabled="!isLoad">
                    Fair
                </button>

                <button class="rate__btn" @click="onAnswer(4)" :disabled="!isLoad">
                    Good
                </button>
                
                <button class="rate__btn" @click="onAnswer(5)" :disabled="!isLoad">
                    Excellent
                </button>
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
    import getRandomInt from '../core/functions/random'
    import Fullscreen from '../core/classes/Fullscreen'
    import Stopwatch from '../core/classes/Stopwatch'
    import modal from '../components/Modal'
    import photo from '../components/Photo'

    export default {
        data() {
            return {
                folder: 'images/CIDIQ/Images/Reproduction/',
                compressionType: '2_JPEG_Compression',

                photos: [],
                path: '',
                isLoad: false,

                answers: [],
                // traningPhotos: [],

                // categories: ['bad', 'poor', 'fair', 'good', 'excellent'],

                photoSet: 0,
                photoSetOrder: 0,
                photoSetOrderIndex: 0,

                completed: 0,
                total: 100,

                fs: new Fullscreen,
                stopwatch: new Stopwatch,

                timer: {
                    start: 0,
                    elapsed: 0
                },

                fullscreen: false,

                modal: {
                    show: false,
                    message: '',
                    header: ''
                }
            }
        },

        components: {
            modal,
            photo
        },

        methods: {
            onAnswer(rating) {
                this.stopwatch.stop()

                if (this.completed > 5) { // don't save the first 5 images (first set)
                    this.saveAnswer(rating)
                }

                if (this.completed == this.total) {
                    this.showThresholdMessage()
                }

                this.completed++

                this.nextPhoto()
            },

            saveAnswer(rating) {
                this.answers.push({
                    time: this.stopwatch.elapsed,
                    answer: rating,
                    image: this.path
                })
            },

            showThresholdMessage() {
                this.modal.header = 'You have completed ' + this.total + ' images!'
                this.modal.message = `
                    It would be greatly appreciated if you would do even more.
                    You can quit at any time by simply closing the browser tab!'
                `
                this.modal.show = true
                this.total += 50 // 
            },
            
            onSubmit() {
                axios.post('answer/store', this.answers).then(response => {
                    console.log(response)
                })
            },

            nextPhoto() {
                this.isLoad = false

                this.stopwatch.stop()

                /* when every image in a set has been shown, select a new set and generate a new random order */
                if (this.photoSetOrderIndex === 5) {
                    this.photoSet = getRandomInt(0, this.photos.length)
                    
                    this.photoSetOrder = _.shuffle( [0, 1, 2, 3, 4] )

                    this.photoSetOrderIndex = 0
                }

                /* nextTick allows you to do something after you have changed the data and VueJS has 
                 * updated the DOM based on your data change, but before the browser has rendered those changed on the page */
                this.$nextTick( () => {
                    this.path = this.folder + this.compressionType + '/' + this.photos[this.photoSet][this.photoSetOrder[this.photoSetOrderIndex]]

                    this.photoSetOrderIndex++
                    this.stopwatch.start()
                })
            },

            /**
             * 
             */
            loaded() {
                this.isLoad = true
            },

            showInstructions() {
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

            onFullscreen() {
                if (this.fullscreen == false) {
                    this.fs.launch(document.documentElement)
                    this.fullscreen = true
                } else {
                    this.fs.exit()
                    this.fullscreen = false
                }
            }

        },

        mounted() {
            // load all photos into instance prop
            this.photos = data.photos

            // get random set
            this.photoSet = getRandomInt(0, this.photos.length)

            // create a random set order
            this.photoSetOrder = _.shuffle( [0, 1, 2, 3, 4] )
            
            this.path = this.folder + this.compressionType + '/' + this.photos[this.photoSet][ this.photoSetOrder[this.photoSetOrderIndex] ]

            this.stopwatch.start()

            // increase...
            this.photoSetOrderIndex++


            /***
             **/
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

    .intrinsic-placeholder {
        /*padding-bottom: 60%;
        position: relative;*/
        width: 800px;
        height: 800px;
    }
</style>