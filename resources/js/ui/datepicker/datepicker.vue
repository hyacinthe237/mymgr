
<template>
    <div class="datepicker-container">
        <input type="text" readonly
               :class="classDesign"
               :value="date_formatted"
               @click="showDatepicker">

        <input type="hidden"
               :id="id"
               :name="name"
               :value="date_raw">

        <datepicker-agenda :disable-passed-days="disablePassedDays"
                           :disable-future-days="disableFutureDays"
                           :doubled="doubled"
                           :disabled-days="disabledDays"
                           :lang="lang"
                           :orientation="orientation"
                           :show="isVisible"
                           :initial-date="initialDate"
                           :autoclose="autoclose"
                           @change="selectDate"
                           @hide="hideDatePicker"
                           @cancel="cancelDateSelection">
        </datepicker-agenda>
    </div>
</template>

<script>
    import moment from 'moment';
    import DatepickerAgenda from './components/DatepickerAgenda.vue';

    export default {
        components: {
            'datepicker-agenda': DatepickerAgenda
        },

        props: {
            classDesign: { type: String, default: '' },
            disablePassedDays: { type: Boolean, default: false },
            disableFutureDays: { type: Boolean, default: false },
            disabledDays: { type: Array, default() { return [] } },
            doubled: { type: Boolean, default: false },
            autoclose: { type: Boolean, default: true },
            format: { type: String, default: 'YYYY-MM-DD' },
            id: { type: String, default: 'vue-datepicker' },
            lang: { type: String, default: 'en' },
            name: { type: String, default: 'datepicker' },
            orientation: { type: String, default: 'portrait' },
            placeholder: { type: String, default: 'Date' },
            initialDate: { type: Object,
                default() {
                    return moment();
                }
            },
        },

        data () {
            return {
                date: '',
                isVisible: false
            }
        },

        computed: {
            date_formatted () {
                if (this.isValidDate(this.date))
                    return this.date.format(this.format);
                return this.placeholder
            },
            date_raw () {
                if (this.isValidDate(this.date))
                return this.date.format('YYYY-MM-DD')
            }
        },

        mounted () {
            moment.locale(this.lang)
        },

        watch: {
            initialDate (val) {
                if (this.isValidDate(val)) this.date = val
            }
        },

        methods: {
            selectDate (newDate) {
                this.date = newDate;
                this.$emit('changed', newDate)
            },

            showDatepicker () {
                this.isVisible = true;
                setTimeout( () => document.addEventListener('click', this.hideDatePicker), 0);
            },

            hideDatePicker () {
                this.isVisible = false;
                document.removeEventListener('click', this.hideDatePicker);
            },

            cancelDateSelection () {
                this.hideDatePicker();
            },

            isValidDate (d) {
                return d instanceof moment
            }
        }
    };
</script>
