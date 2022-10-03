<template>
    <button class="btn" @click="clicked()" :disabled="shouldDisable"
        :class="[block ? 'btn-block' : '', elevated ? 'elevated' : '', btnColour, btnSize]">
        <span v-show="loading">
            <hollow-dots-spinner
                :animation-duration="1000"
                :dot-size="14"
                :dots-num="3"
                :color="colour"/>
        </span>
        <slot v-if="!loading"></slot>
    </button>
</template>

<script>
import { HollowDotsSpinner } from 'epic-spinners'

export default {
    name: 'z-btn',
    props: {
        colour: {
            type: String,
            default: '#ffffff'
        },

        bg: {
            type: String,
            default: 'primary'
        },

        block: {
            type: Boolean,
            default: false
        },

        elevated: {
            type: Boolean,
            default: false
        },

        disabled: {
            type: Boolean,
            default: false
        },

        loading: {
            type: Boolean,
            default: false
        },

        size: {
            type: String,
            default: 'lg',
            validator: value => {
                return ['lg', 'sm', 'md'].includes(value)
            }
        }
    },

    components: {
        HollowDotsSpinner
    },

    computed: {
        btnColour () {
            return 'btn-' + this.bg
        },

        btnSize () {
            return 'btn-' + this.size
        },

        shouldDisable () {
            if (this.disabled) return this.disabled
            return this.loading
        }
    },

    methods: {
        clicked () {
            this.$emit('clicked')
        }
    }
}
</script>

<style media="screen" scoped>
    .btn-lg {
        height: 45px;
        line-height: 25px;
        text-align: center;
    }

    .hollow-dots-spinner {
        margin: 0 auto;
    }
</style>
