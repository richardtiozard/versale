<template>
    <div class="componentwarpper">
        <div class="warpper min-vh-100">
            <div class="content-warpper d-flex justify-content-between">
                <h4 class="d-inline-block font-weight-600">Total Offers Received ({{this.data.offers.length}} Offers)</h4>
            </div>

            <div class="content-warpper row justify-content-between">
                <div v-if="!isReview" class="col-4 position-relative p-0">
                    <div class="request-box p-4 text-center position-sticky top-center mt-5">
                        <h6 class="text-left lead">My Request</h6>
                        <hr>
                        <img class="categoryimg mt-3" :src="data.offers[0].category_image" alt="">
                        <h4 class="mt-3 text-4">{{ data.offers[0].category_subcategory2 }}</h4>
                        <div class="row mt-5">
                            <p class="col-3 text-6 text-left ">Title</p><p class="col-9 text-6 text-left">: {{ data.offers[0].request_title }}</p>
                            <p class="col-3 text-6 text-left">Budget</p><p class="col-9 text-6 text-left">: RM {{ data.offers[0].request_budget }}</p>
                            <p class="col-3 text-6 text-left">Quantity</p><p class="col-9 text-6 text-left">: {{ data.offers[0].request_quantity }}</p>
                            <p class="col-3 text-6 text-left">Description</p><p class="col-9 text-6 text-left">: {{ data.offers[0].request_description }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-7">
                    <div v-for="item in data.offers" class="request-box text-left mt-5 row">
                        <div class="col-4 p-4">
                            <img :src="item.product_image" alt="versale product offer" class="productofferimg">
                        </div>
                        <div class="col-8 p-4">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <h6 class="font-weight-600">{{ item.product_name }}</h6>
                                </div>
                                <div class="col text-right">
                                    <div v-if="item.product_avg_rating == 5" >
                                        <i v-for="index in 5" class="fas fa-star text-rating"></i>
                                    </div>
                                    <div v-if="item.product_avg_rating > 4 && item.product_avg_rating < 5" >
                                        <i v-for="index in 4" class="fas fa-star text-rating"></i><i v-for="index in 1" class="fas fa-star-half-alt text-rating"></i>
                                    </div>
                                    <div v-if="item.product_avg_rating == 4" >
                                        <i v-for="index in 4" class="fas fa-star text-rating"></i><i v-for="index in 1" class="far fa-star text-rating"></i>
                                    </div>
                                    <div v-if="item.product_avg_rating > 3 && item.product_avg_rating < 4" >
                                        <i v-for="index in 3" class="fas fa-star text-rating"></i><i v-for="index in 1" class="fas fa-star-half-alt text-rating"></i><i v-for="index in 1" class="far fa-star text-rating"></i>
                                    </div>
                                    <div v-if="item.product_avg_rating == 3" >
                                        <i v-for="index in 3" class="fas fa-star text-rating"></i><i v-for="index in 2" class="far fa-star text-rating"></i>
                                    </div>
                                    <div v-if="item.product_avg_rating > 2 && item.product_avg_rating < 3" >
                                        <i v-for="index in 2" class="fas fa-star text-rating"></i><i v-for="index in 1" class="fas fa-star-half-alt text-rating"></i><i v-for="index in 2" class="far fa-star text-rating"></i>
                                    </div>
                                    <div v-if="item.product_avg_rating == 2" >
                                        <i v-for="index in 2" class="fas fa-star text-rating"></i><i v-for="index in 3" class="far fa-star text-rating"></i>
                                    </div>
                                    <div v-if="item.product_avg_rating > 1 && item.product_avg_rating < 2" >
                                        <i v-for="index in 1" class="fas fa-star text-rating"></i><i v-for="index in 1" class="fas fa-star-half-alt text-rating"></i><i v-for="index in 3" class="far fa-star text-rating"></i>
                                    </div>
                                    <div v-if="item.product_avg_rating == 1" >
                                        <i v-for="index in 1" class="fas fa-star text-rating"></i><i v-for="index in 4" class="far fa-star text-rating"></i>
                                    </div>
                                    <div v-if="!item.product_avg_rating" >
                                        <span class="text-rating"><i>Not Rated</i></span>
                                    </div>
                                    <span @click="viewReview(item.product_id)" class="text-7 cursor-pointer mt-1">View <i class="fas fa-eye"></i></span> 
                                </div>
                            </div>
                            <p class="text-left mt-2">
                                Brand: {{ item.product_brand }} <br/>
                                Description: {{ item.product_description }}
                            </p>
                            <div class="row mt-5">
                                <div class="col-6">
                                    <h1 id="pricetag_num" class="font-weight-200 d-inline">{{ item.product_price }}</h1> <span class="d-inline">RM</span>
                                </div>
                                <div class="col-6">
                                    <a :href="'/checkout/'+item.offer_id"><div class="accept-button">Accept Offer</div></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="isReview" class="col-4 position-relative p-0">
                    <div id="productreview-box" class="request-box position-sticky top-center mt-5 overflow-y-auto overflow-x-hidden">
                        <div class="row pt-4 px-4">
                            <h6 class="col-10 text-left lead">Product Reviews</h6>
                            <i @click="toggleIsReview" class="col-2 text-8 text-right fas fa-times cursor-pointer"></i>
                        </div>
                        <div class="row align-items-center bg-1 shadow-sm py-3 px-4 position-sticky sticky-top">
                            <div class="col-4">
                                <img class="productreviewimg" :src="product_review[0].product_image" alt="">
                            </div>
                            <div class="col-8 text-left">
                                <h6 class="font-weight-600">{{ product_review[0].product_name }}</h6>
                                <span>Brand: {{ product_review[0].product_brand }}</span>                             
                            </div>
                        </div>
                        <div class="px-4 mt-4">
                            <div v-if="item.seller_rating_id != null" v-for="item in product_review" class="row mt-3">
                                <div class="col-3">
                                    <img class="buyerimg" :src="item.buyer_image" alt="">
                                </div>
                                <div class="col-9 text-left">
                                    <div class="row">
                                        <h6 class="col font-weight-600">{{ item.buyer_username }}</h6>
                                        <div class="col text-right">
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
                                                <span class="text-rating"><i>Not Rated</i></span>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <p class="text-7">"{{ item.seller_rating_message }}"</p>
                                </div>
                            </div>
                            <div v-else>
                                <img :src="'/img/illustrator/emptyview.png'" class="pointer-events-none empty-img d-block" alt="">
                                <span class="text-7">This product does not have any rating or review yet.</span> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <Footers/>
    </div>
    
</template>

<script>
import Footers from '../../template/Footers.vue'

export default {
    props: ['data'],
    components:{
        Footers,
    },
    data(){
        return{

            isReview: false,
            product_review: [],
        }
    },
    methods:{

        toggleIsReview(){
            this.isReview = !this.isReview;
        },

        viewReview(prod_id){
            var arr = [];
            this.isReview = true;
            for (var item in this.data.product_reviews){
                if (this.data.product_reviews[item].product_id == prod_id){
                    arr.push(this.data.product_reviews[item]);
                }
            }
            this.product_review = arr;
        }
    },
    mounted(){
        console.log(this.data);
        if (this.data.offers == ''){
            window.location.replace("/requests");
        }
    }
}

</script>

<style scoped>
    .content-warpper{
        width: 75%;
        margin: 0 auto;
    }

    .categoryimg{
        width: 50px;
    }
    .buyerimg{
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 50%;
    }
    .requestbox-bgimg{
        position: absolute;
        bottom: 0;
        right: 0;
        width: 100%;
        z-index: -1;
        opacity: 0.05;
        pointer-events: none;
    }
    .productofferimg{
        width: 100%;
        height: 200px;
        object-fit: contain;
    }
    .productreviewimg{
        width: 100%;
        height: 75px;
        object-fit: contain;
    }
    .empty-img{
        opacity: 0.8;
    }

    .request-box{
        background-color: #fff;
        text-align: center;
        box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
        transition: all 0.2s ease-in-out 0s;
    }
    #productreview-box{
        height: 500px;
    }
    .top-center{
        top: 25%;
    }
    .sticky-top{
        position: sticky;
        top: 0;
    }
    .request-box h4{
        font-weight: 600;
    }
    #pricetag_num{
        font-size: 36pt;
    }

    .accept-button {
        cursor: pointer;
        line-height: 45px;
        margin-top: 15px;
        width: 100%; 
        text-align: center;
        color: #FCFAF1;
        background-color: rgba(144, 46, 46, 1);

        box-shadow: inset 0 0 20px rgba(46, 130, 139, 0);
        outline-color: rgba(144, 46, 46, .5);
        outline-offset: 0px;
        text-shadow: none;
        transition: all 1250ms cubic-bezier(0.19, 1, 0.22, 1);
    }
    .accept-button:hover {
        box-shadow: inset 0 0 20px rgba(144, 46, 46, .5), 0 0 20px rgba(144, 46, 46, .2);
        outline: 1px solid;
        outline-color: rgba(144, 46, 46, 0);
        outline-offset: 15px;
        text-shadow: 1px 1px 2px #2E828B; 
    }

    #requestbutton{
        position: fixed;
        top: 50%;
        left: 50px;
        z-index: 5;
    }
    #reviewbutton{
        position: fixed;
        top: 50%;
        right: 50px;
        z-index: 5;
    }

    /* TRANSITION */
    .slideleft-enter-from,
    .slideleft-leave-to{
        transform: translateX(-250px);
    }
    .slideleft-enter-active,
    .slideleft-leave-active{
        transition: all 1s ease-in-out 0s;
    }
    
    .move-move{
        opacity: 0;
        transform: translateX(-250px);
    }
    .move-move-active{
        transition: all 1s ease-in-out 0s;
    }

    .slideright-enter-from,
    .slideright-leave-to{
        transform: translateX(250px);
    }
    .slideright-enter-active,
    .slideright-leave-active{
        transition: all 1s ease-in-out 0s;
    }

</style>