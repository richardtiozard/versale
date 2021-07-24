<template>
    <div class="componentwarpper">
        <div class="warpper px-5">
            <h4 class="font-weight-600"><i class="fas fa-users"></i> Users Data</h4>
            <div class="row mt-4 pt-5 pb-4">
                <div class="col-4 text-center">
                    <h4 v-if="data.total_admin[0].total_admin">{{ data.total_admin[0].total_admin}}</h4>
                    <h4 v-else>0</h4>
                    <p class="text-7">Total Admin(s)</p>
                </div>
                <div class="col-4 text-center">
                    <h4 v-if="data.total_seller[0].total_seller">{{ data.total_seller[0].total_seller }}</h4>
                    <h4 v-else>0</h4>
                    <p class="text-7">Total Seller(s)</p>
                </div>
                <div class="col-4 text-center">
                    <h4 v-if="data.total_buyer[0].total_buyer">{{ data.total_buyer[0].total_buyer }}</h4>
                    <h4 v-else>0</h4>
                    <p class="text-7">Total Buyer(s)</p>
                </div>
            </div>
        </div>
        <div class="warpper px-5">
            <h4 class="font-weight-600"><i class="fas fa-boxes"></i> Miscellaneous</h4>
            <div class="row mt-4 pt-5 pb-4">
                <div class="col-4 text-center">
                    <h4 v-if="data.total_order[0].total_order">{{ data.total_order[0].total_order }}</h4>
                    <h4 v-else>0</h4>
                    <p class="text-7">Completed Orders</p>
                </div>
                <div class="col-4 text-center">
                    <h4 v-if="data.total_feedback[0].total_feedback">{{ data.total_feedback[0].total_feedback }}</h4>
                    <h4 v-else>0</h4>
                    <p class="text-7">Pending Feedbacks</p>
                </div>
                <!-- <div class="col-4 text-center">
                    <h4 v-if="data.avg_rating[0].avg_rating">{{ data.avg_rating[0].avg_rating}}/5</h4>
                    <h4 v-else>Not Rated Yet</h4>
                    <p class="text-7">Average Rating</p>
                </div> -->
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
        console.log(this.data)
    }
}
</script>

<style scoped>

</style>