<template>
    <nav>
        <ul class="pagination">
            <li 
                :class="['page-item', isPreviousDisabled ? 'disabled' : '']"
                @click="openPage(previous)"
            >
                <span class="page-link" aria-hidden="true">&lsaquo;</span>
            </li>

            <li 
                v-for="(l, index) in links"
                :key="index + 1"
                :class="['page-item', current == l ? 'active' : '']"
                @click="openPage(l)"
            >
                <span class="page-link">{{ l }}</span>
            </li>

            <li 
                class="['page-item', isNextDisabled ? 'disabled' : '']"
                @click="openPage(next)"
            >
                <span class="page-link" rel="next" aria-label="Next &raquo;">&rsaquo;</span>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: 'pagination',

    props: {
        current: { type: Number, default: 1 },
        last: { type: Number, default: 1 },
    },

    data: () => ({
        places: []
    }),

    computed: {
        previous () {
            return this.current > 1 ? this.current : 1
        },

        next () {
            return this.current < this.last ? this.current + 1 : this.last
        },

        isPreviousDisabled () {
            return this.current === 1
        },

        isNextDisabled () {
            return this.current === this.last
        },

        links () {
            let current = this.current 
            let total = this.last

            if (total === 1) return [1]

            const center = [current - 1, current, current + 1],
            filteredCenter = center.filter((p) => p > 1 && p < total),
            includeLeftDots = current >= 4,
            includeRightDots = current < total - 2;

            if (current < 4 && total > 4) {
                for (let i = current + 2; i <= 5; i++) {
                    filteredCenter.push(i)
                }
            }

            if (current >= total - 2 && total > 4) {
                for (let i = current - 2; i > total - 5; i--) {
                    filteredCenter.unshift(i)
                }
            }

            if (includeLeftDots) filteredCenter.unshift('...');
            if (includeRightDots) filteredCenter.push('...');

            return [1, ...filteredCenter, total]
        }
    },

    methods: {
        openPage (page) {
            console.log('Opening page ==> ', page)
            if (this.current === page) {
                return console.log('trying to open the current page ==> ', page)
            }

            if (page === '...') return console.log('Trying to open ellipsis ...')
            this.$emit('clicked', page)
        }
    }
}
</script>