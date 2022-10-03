<template>
    <div class="form-group">
        <div class="field-wrapper">
            <input :type="type" 
                :name="name"
                :disabled="disabled" 
                :autocomplete="autocomplete" 
                :data-vv-as="validateAs"
                v-validate="validation" 
                :class="css"
                :value="value"
                @input="changed"
            >
            <div class="field-placeholder">
                <span>{{ placeholder }}</span>
            </div>
        </div> 

        <v-error :name="name" :err="errors"/>      
    </div>
</template>

<script>
export default {
    name: 'z-float',
    inject: ['$validator'],

    props: {
        id: { type: String, default: `id` },
        css: { type: String, default: '' },
        type: { type: String, default: 'text' },
        name: { type: String, default: 'name' },
        value: { type: String, default: '' },
        disabled: { type: Boolean, default: false },
        autocomplete: { type: String, default: 'off' },
        placeholder: { type: String, default: 'Enter text here' },
        validation: { type: String, default: '' },
        validateAs: { type: String, default: '' },
    },

    methods: {
        changed (e) {
            this.$emit('changed', e.target.value)
        }
    }
}
</script>