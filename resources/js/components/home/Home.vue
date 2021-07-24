<template>
    <div class="componentwarpper">
        <carousel/>
        <how-it-works/>
        <become-seller/>
        <why-choose-us/>
        <footers/>
    </div>
</template>

<script>

import Carousel from './subcomponents/Carousel.vue';
import HowItWorks from './subcomponents/HowItWorks.vue';
import BecomeSeller from './subcomponents/BecomeSeller.vue';
import WhyChooseUs from './subcomponents/WhyChooseUs.vue';
import Footers from '../template/Footers.vue';

export default {
    components: {
        Carousel,
        HowItWorks,
        BecomeSeller,
        WhyChooseUs,
        Footers,
    },
    data() {
        return {
            
        }
    },
    methods: {
        
    }
}
</script>

<style scoped>


</style>
