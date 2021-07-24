<template>
    <div class="componentwarpper">
        <div class="warpper min-vh-100">

            <div class="content-warpper bg-1 custom-box-shadow pt-5 pb-4">
                <h5 class="px-5">My Orders</h5>

                <div class="filter-nav bg-1 px-5 py-4">
                    <div @click="getAllOrders" class="filter-button d-inline-block text-center mr-2 py-1 text-7 cursor-pointer" :class="{active: filter == 'All'}">
                        All
                    </div>
                    <div @click="getPendingOrders" class="filter-button d-inline-block text-center mr-2 py-1 text-7 cursor-pointer" :class="{active: filter == 'Pending'}">
                        Pending Orders
                    </div>
                    <div @click="getCompletedOrders" class="filter-button d-inline-block text-center mr-2 py-1 text-7 cursor-pointer" :class="{active: filter == 'Completed'}">
                        Completed Orders
                    </div>
                </div>
                <div class="mt-3 px-5">
                    <div v-for="item in orders" class="mt-5 p-4 custom-box-shadow-3 w-100">
                        <div class="row justify-content-between px-3">
                            <h6 class="font-weight-600">{{ item.seller_username }}</h6>
                            <p class="text-7">{{ item.payment_created_at | moment("dddd, MMMM Do YYYY, h:mm:ss a") }}</p>
                        </div>


                        <div class="row mt-2 align-items-end px-4">
                            <img :src="item.product_image" alt="" class="productimg col-2">
                            <div class="col-6">
                                <h6>{{ item.product_name }}</h6>
                                <p class="text-7">Description: {{ item.product_description }}</p>
                                <p class="">x{{ item.request_quantity }}</p>
                            </div>
                            <div class="col-4 text-right p-0 ">
                                 <p class="text-3">{{ item.order_status }}</p>
                                <p class="d-inline">Order Total:</p>&nbsp;&nbsp;<h4 class="d-inline font-weight-200 text-3"> RM{{ item.payment_amount }} </h4>
                                <div v-if="item.order_status == 'Completed'" class="mt-3">
                                    <div v-if="item.seller_rating_rating == 5" >
                                        <i v-for="index in 5" class="fas fa-star text-rating"></i>
                                    </div>
                                    <div v-if="item.seller_rating_rating > 4 && item.seller_rating_rating < 5" >
                                        <i v-for="index in 4" class="fas fa-star text-rating"></i><i v-for="index in 1" class="fas fa-star-half-alt text-rating"></i>
                                    </div>
                                    <div v-if="item.seller_rating_rating == 4" >
                                        <i v-for="index in 4" class="fas fa-star text-rating"></i><i v-for="index in 1" class="far fa-star text-rating"></i>
                                    </div>
                                    <div v-if="item.seller_rating_rating > 3 && item.seller_rating_rating < 4" >
                                        <i v-for="index in 3" class="fas fa-star text-rating"></i><i v-for="index in 1" class="fas fa-star-half-alt text-rating"></i><i v-for="index in 1" class="far fa-star text-rating"></i>
                                    </div>
                                    <div v-if="item.seller_rating_rating == 3" >
                                        <i v-for="index in 3" class="fas fa-star text-rating"></i><i v-for="index in 2" class="far fa-star text-rating"></i>
                                    </div>
                                    <div v-if="item.seller_rating_rating > 2 && item.seller_rating_rating < 3" >
                                        <i v-for="index in 2" class="fas fa-star text-rating"></i><i v-for="index in 1" class="fas fa-star-half-alt text-rating"></i><i v-for="index in 2" class="far fa-star text-rating"></i>
                                    </div>
                                    <div v-if="item.seller_rating_rating == 2" >
                                        <i v-for="index in 2" class="fas fa-star text-rating"></i><i v-for="index in 3" class="far fa-star text-rating"></i>
                                    </div>
                                    <div v-if="item.seller_rating_rating > 1 && item.seller_rating_rating < 2" >
                                        <i v-for="index in 1" class="fas fa-star text-rating"></i><i v-for="index in 1" class="fas fa-star-half-alt text-rating"></i><i v-for="index in 3" class="far fa-star text-rating"></i>
                                    </div>
                                    <div v-if="item.seller_rating_rating == 1" >
                                        <i v-for="index in 1" class="fas fa-star text-rating"></i><i v-for="index in 4" class="far fa-star text-rating"></i>
                                    </div>
                                    <div v-if="!item.seller_rating_rating" >
                                        <span @click="openRating(item)" class="text-rating cursor-pointer">Rate Now</span>
                                    </div>
                                </div>
                                <div v-if="item.order_status == 'Pending'" class="mt-3">
                                    <p class="text-7">Your order has been sent. Waiting for delivery.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="orders==''" class="text-7 w-100 text-center">
                        <img :src="'../img/illustrator/emptyview.png'" class="pointer-events-none empty-img" alt="">
                        <p>No purchase history found.</p>
                    </div>
                </div>
            </div>

        </div>
        <Footers/>
        <Rating v-if="toggleRating" @confirmed="rateProduct" @closeRating="closeRating"></Rating>
    </div>
    
</template>

<script>
import Footers from '../../template/Footers.vue';
import Rating from '../../template/Rating.vue';

export default {
    props: ['data'],
    components:{
        Footers,
        Rating
    },
    data(){
        return{
            orders: this.data.orders,
            filter: 'All',

            toggleRating: false,
            selected_product_id: '',
        }
    },
    methods:{

        /* RATE PRODUCT */
        rateProduct(rating, message){
            
            axios.post('/sellerratings', {
                rating: rating,
                message: message,
                product_id: this.selected_product_id
            })
            .then( response => {
                window.location.href = "/orders";
            })
            .catch( err => {
                console.log(err.response.data);
            })
        },
        openRating(offer){
            this.selected_product_id = offer.product_id;
            this.toggleRating = true;
            document.body.style.overflow = 'hidden';
        },
        closeRating(){
            this.toggleRating = false;
            document.body.style.overflow = 'auto';
        },
        
        /* FILTER ORDERS */
        getAllOrders(){
            this.filter = 'All';
            this.orders = this.data.orders
        },
        getPendingOrders(){
            var arr = [];
            for (var item in this.data.orders){
                if(this.data.orders[item].order_status == 'Pending'){
                    arr.push(this.data.orders[item]);
                }
            }
            this.filter = 'Pending';
            this.orders = arr;
        },
        getCompletedOrders(){
            var arr = [];
            for (var item in this.data.orders){
                if(this.data.orders[item].order_status == 'Completed'){
                    arr.push(this.data.orders[item]);
                }
            }
            this.filter = 'Completed';
            this.orders = arr;
        },
        
    },
    computed:{
        total_amount(){
            return this.data.offer[0].product_price * this.data.offer[0].request_quantity;
        }
    },
    watch:{
        'default_address': function(newVal, oldVal){
            this.toggleDefaultAddress(newVal);
        },
    },
    mounted(){
        console.log(this.data);
    }
}

</script>

<style scoped>
    .content-warpper{
        position: relative;
        width: 75%;
        margin: 0 auto;
    }
    .filter-nav{
        position: sticky;
        top: 70px;
        z-index: 10;
    }
    .filter-button{
        width: 150px;
        transition: all 0.2s ease-in-out 0s;
    } 
    .filter-button:hover{
        color: #134153;
    } 
    .filter-button.active{
        border-bottom: 4px solid #134153;
        font-weight: 600;
        color: #134153;
    } 
    .productimg{
        width: 100px;
        height: 100px;
        object-fit: contain;
        /* border: 1px solid rgba(0, 0, 0, 0.1); */
    }

    

</style>