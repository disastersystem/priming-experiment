<template>
	<transition name="modal">
		<img :src="url" ref="thephoto" :key="url">
        <!-- v-if="show" -->
	</transition>
</template>

<script>
	export default {
        data() {
            return {
            	show: false,
                url: ''
            }
        },

        props: ['path'],

        mounted() {
            var img = new Image()
            var that = this

            // this.$nextTick(function () {
                /* wait until photo is fully loaded before displaying */
                img.onload = function() {
                    that.url = that.path
                    // this.$refs.thephoto.src = this.src
                    // that.$el.src = this.src
                    console.log('hello')
                    /* trigger fade in animation */
                    that.show = true
                    img.src = that.path
                }.bind(this)

                img.src = that.path
            // })
        }
    }
</script>

<style scoped>
	img {
		/*width: 100%;*/
        /*height: 800px;*/
        /*width: 800px;*/
		position: absolute;
		top: 0;
		left: 0;
	}
</style>