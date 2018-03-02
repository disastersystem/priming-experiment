<template>
    <div>
        <div class="flex-center position-ref full-height">
            <div class="top-bar">
                <span>{{ results }} / {{ total }}</span>

                <div>
                    <button @click="showInfo()" class="info__btn">
                        <img src="icons/info.png" style="width: 25px;">
                    </button>

                    <button @click="goFullscreen()" class="fullscreen__btn">
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
                folder: 'images/CIDIQ/images/reproduction/',
                compressionType: '2_JPEG_Compression',

                answers: [],
                results: 0,
                total: 50,

                modal: {
                    show: false,
                    message: '',
                    header: ''
                }
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

                var result = {
                    answer: rating,
                    image: this.path,
                    subject: window.localStorage.getItem('id')
                }

                axios.post('answer/store', result).then(function (response) {
                    if (response.data == 'saved') {
                        vm.results++
                        
                        if (vm.results == vm.total) {
                            vm.modal.header = 'You have completed ' + vm.total + ' images!'
                            vm.modal.message = `
                                It would be greatly appreciated if you would do even more.
                                You can quit at any time, results gets continually saved!'
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
            },

            changeImage() {
                let randSetNum = this.getRandomInt(0, this.images.length)
                let randImageNum = this.getRandomInt(0, this.images[randSetNum].length)

                this.path = this.folder + this.compressionType + '/' + this.images[randSetNum][randImageNum]
            },

            showInfo() {
                this.modal.header = 'About'
                this.modal.message = `
                    <p>
                        Rate the images quality by selecting 1 of the 5 categories.<br>
                        The first 4 images are training images and will not count.
                    </p>
                    <p>It would be beneficial if:</p>
                    <ul>
                        <li>You turn up the brightness of your screen as high as possible.</li>
                        <li>When you're ready, enter full screen mode in your browser by hitting the
                        button in the right corner.</li>
                    </ul>
                `
                this.modal.show = true
            },

            goFullscreen() {
                var elem = document.querySelector("html")

                if (elem.requestFullscreen) {
                    elem.requestFullscreen()
                } else if (elem.msRequestFullscreen) {
                    elem.msRequestFullscreen()
                } else if (elem.mozRequestFullScreen) {
                    elem.mozRequestFullScreen()
                } else if (elem.webkitRequestFullscreen) {
                    elem.webkitRequestFullscreen()
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

            this.modal.header = 'Welcome'
            this.modal.message = `
                <p>
                    Thanks for participating in this experiment.<br>
                    Rate the images quality by selecting 1 of the 5 categories.<br>
                    The first 4 images are training images and will not count.
                </p>
                <p>It would be beneficial if:</p>
                <ul>
                    <li>You turn up the brightness of your screen as high as possible.</li>
                    <li>Enter full screen mode in your browser by hitting the
                    button in the right corner.</li>
                </ul>
            `
            this.modal.show = true
        }
    }
</script>

<style scoped>
    .top-bar {
        display: flex;
        justify-content: flex-end;
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
        margin-left: 40px;
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
    }

    .rating-bar {
        position: fixed;
        bottom: 0;
        padding: 30px;
        z-index: 10;
    }
</style>