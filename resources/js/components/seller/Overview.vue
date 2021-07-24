<template>
    <div class="componentwarpper">
        <div class="warpper px-5">
            <h4 class="font-weight-600"><i class="fas fa-chart-bar mr-2"></i> Sales Data</h4>
            <div class="row mt-4 pt-5 pb-4">
                <div class="col-4 text-center">
                    <h4 v-if="data.total_ravenue[0].total_ravenue">{{ data.total_ravenue[0].total_ravenue}}</h4>
                    <h4 v-else>0</h4>
                    <p class="text-7">Total Ravenue (MYR)</p>
                </div>
                <div class="col-4 text-center">
                    <h4 v-if="data.completed_orders[0].orderNum">{{ data.completed_orders[0].orderNum }}</h4>
                    <h4 v-else>0</h4>
                    <p class="text-7">Completed Orders</p>
                </div>
                <div class="col-4 text-center">
                    <h4 v-if="data.pending_orders[0].orderNum">{{ data.pending_orders[0].orderNum }}</h4>
                    <h4 v-else>0</h4>
                    <p class="text-7">Pending Orders</p>
                </div>
            </div>
        </div>
        <div class="warpper px-5">
            <h4 class="font-weight-600"><i class="fas fa-box-open mr-2"></i> Products Data</h4>
            <div class="row mt-4 pt-5 pb-4">
                <div class="col-4 text-center">
                    <h4 v-if="data.total_products">{{ data.total_products }}</h4>
                    <h4 v-else>0</h4>
                    <p class="text-7">Products Listed</p>
                </div>
                <div class="col-4 text-center">
                    <h4 v-if="data.top_products[0]">{{ data.top_products[0].name }}</h4>
                    <h4 v-else>None</h4>
                    <p class="text-7">Top Products</p>
                </div>
                <div class="col-4 text-center">
                    <h4 v-if="data.avg_rating[0].avg_rating">{{ data.avg_rating[0].avg_rating}}/5</h4>
                    <h4 v-else>Not Rated Yet</h4>
                    <p class="text-7">Average Rating</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:[
        'data'
    ],
    mounted(){

    }
}
</script>

<style scoped>

</style>