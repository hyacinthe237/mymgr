<template>
    <semipolar-spinner
      :animation-duration="2000"
      :size="50" color="#005FBF"/>
</template>

<script>
import { SemipolarSpinner  } from 'epic-spinners'

export default {
    name: 'circle-loader',
    components: { SemipolarSpinner }
}
</script>


<style scoped>
    .semipolar-spinner {
        margin: 0 auto;
    }
</style>
