<template>
	<button @click="$emit('close')" class="fullscreen__btn" title="Fullscreen mode">
        <img src="icons/fullscreen.png" style="width: 25px;">
    </button>
</template>

<script>
	import Fullscreen from '../core/classes/Fullscreen'

	
</script>

<style>
	.fullscreen__btn {
        padding: 2px;
        font-weight: bold;
        background-color: #e1e1e1;
        border: none;
        outline: 0;
        cursor: pointer;
        margin-left: 40px;
    }
</style>