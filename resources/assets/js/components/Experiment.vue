<template>
    <div>
        <div class="flex-center position-ref full-height">
            <div class="top-bar">
                <button @click.prevent="showInstructions" class="info__btn" title="Information">
                    <img src="icons/info.png" style="width: 25px;">
                </button>
                
                <div style="display: flex; align-items: center;">
                    <span>{{ completed }} / {{ threshold }}</span>

                    <button @click.prevent="onFullscreen()" class="fullscreen__btn" title="Fullscreen mode">
                        <img src="icons/fullscreen.png" style="width: 25px;">
                    </button>

                    <button v-if="completed > 3" @click.prevent="onSubmit">
                        {{ completed }} - Finish
                    </button>
                </div>
            </div>

            <div class="img-box">
                <transition>
                    <img v-show="isLoad" :src="path" @load="loaded">
                </transition>

                <div v-show="!isLoad" class="loading">
                    Loading...
                </div>
            </div>

            <div class="rating-bar">
                <button class="rate__btn" @click="onAnswer(1)">Bad</button> <!-- :disabled="!isLoad" -->
                <button class="rate__btn" @click="onAnswer(2)">Poor</button>
                <button class="rate__btn" @click="onAnswer(3)">Fair</button>
                <button class="rate__btn" @click="onAnswer(4)">Good</button>
                <button class="rate__btn" @click="onAnswer(5)">Excellent</button>
            </div>
        </div>

        <modal v-if="modal.show" @close="modal.show = false">
            <h3 slot="header" v-html="modal.header"></h3>

            <div slot="body" v-html="modal.message"></div>
        </modal>
    </div>
</template>

<script>
    import data from '../data' // photos and messages

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

                photoSet: 0,
                photoSetOrder: 0,
                photoSetOrderIndex: 0,

                threshold: 100,
                completed: 0,

                fs: new Fullscreen,
                stopwatch: new Stopwatch,

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
            /**
             * Called when a stimuli has been rated.
             */
            onAnswer(rating) {
                this.stopwatch.stop()

                /* don't save the first 5 images (first set) */
                if (this.completed > 5) {
                    this.saveAnswer(rating)
                }

                /* amount of completed stimuli has reached the limit we set */
                if (this.completed == this.threshold) {
                    this.onThresholdReached()
                }

                this.completed++

                this.nextPhoto()
            },

            saveAnswer(rating) {
                this.answers.push({
                    time: this.stopwatch.elapsed,
                    answer: rating,
                    image: this.path,
                    subject: ''
                })
            },

            onThresholdReached() {
                this.modal.header = 'You have completed ' + this.threshold + ' images! Thank you very much.'
                this.modal.message = data.messages.threshold
                this.modal.show = true

                // increase stimuli to complete by 50, we want to give them a new goal to reach for
                this.threshold += 50
            },
            
            onSubmit() {
                axios.post('answer/store', this.answers).then(response => {
                    this.answers = []
                })
            },

            /**
             * Load a new photo stimuli.
             */
            nextPhoto() {
                this.isLoad = false // set isLoad to false until photo has been fully loaded

                this.stopwatch.stop()

                /* when every image in a set has been shown, select a new set and generate a new random order */
                if (this.photoSetOrderIndex === 5) {
                    this.photoSet = getRandomInt(0, this.photos.length)
                    
                    this.photoSetOrder = _.shuffle([0, 1, 2, 3, 4])

                    this.photoSetOrderIndex = 0
                }

                /* nextTick allows you to do something after you have changed the data and VueJS has 
                 * updated the DOM based on your data change, but before the browser has rendered those changed on the page */
                this.$nextTick( () => {
                    this.path = this.folder + this.compressionType + '/' + this.photos[this.photoSet][this.photoSetOrder[this.photoSetOrderIndex]]

                    this.stopwatch.start()
                    this.photoSetOrderIndex++
                })
            },

            loaded() {
                this.isLoad = true
            },

            showInstructions() {
                this.modal.header = 'About'
                this.modal.message = data.messages.instructions
                this.modal.show = true
            },

            onFullscreen() {
                if (this.fullscreen == false) {
                    this.fs.launch(document.documentElement) //launch the root element of the document (<html>) in fullscreen
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

            // set a random photo set
            this.photoSet = getRandomInt(0, this.photos.length)

            // set a random photo set order
            this.photoSetOrder = _.shuffle( [0, 1, 2, 3, 4] )
            
            this.path = this.folder + this.compressionType + '/' + this.photos[this.photoSet][ this.photoSetOrder[this.photoSetOrderIndex] ]

            this.stopwatch.start()

            // we've loaded the first image in our shuffled set order array, go to index two
            this.photoSetOrderIndex++

            // display a modal with experiment instructions
            this.modal.header = 'Thank you for participating in this experiment!'
            this.modal.message = data.messages.instructions
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