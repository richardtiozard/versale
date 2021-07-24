<template>
    <div class="componentwarpper">
        <div class="warpper min-vh-100">
            <div class="content-warpper d-flex justify-content-between">
                <h4 class="d-inline-block font-weight-600">Explore Requests</h4>
                <a :href="'/seller/offers'">
                    <div class="d-inline-block text-3">
                        My Offers <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            </div>
            <div class="content-warpper mt-2">
                <p class="text-7">Note: The requests are shown based on your product's categories.</p>
            </div>
            <div v-if="data.requests==''" class="text-7 w-100 text-center mt-5">
                <img :src="'../img/illustrator/emptyview.png'" class="pointer-events-none empty-img" alt="">
                <p>No request to be shown. You may want to list some products first.</p>
            </div>

            <div class="content-warpper request-list mt-5">
                <div v-for="request in data.requests" :key="request.id" class="request-box p-4 text-center">
                    <div v-if="checkOfferIsExist(request.id)" class="offeredflag py-1 px-5 shadow-sm">Offered</div>
                    <p class="text-7 timestamp">{{request.created_at | moment("from") }}</p>
                    <img class="categoryimg" :src="request.category_image" alt="">
                    <h4 class="mt-3">{{ request.title }}</h4>
                    <h6 class="text-7">{{ request.description }}</h6>
                    <h2 class="font-weight-200 py-3">RM {{ request.budget }}</h2>
                    
                    <hr>
                    <div class="row justify-content-center">
                        <div>
                            <img class="buyerimg rounded-circle shadow mx-2" :src="request.buyer_image" alt="">
                        </div>
                        <div class="text-left">
                            <span class=" text-3">{{request.username}}</span>
                            <div v-if="request.avg_rating == 5" >
                                <i v-for="index in 5" class="fas fa-star text-rating"></i>
                            </div>
                            <div v-if="request.avg_rating > 4 && request.avg_rating < 5" >
                                <i v-for="index in 4" class="fas fa-star text-rating"></i><i v-for="index in 1" class="fas fa-star-half-alt text-rating"></i>
                            </div>
                            <div v-if="request.avg_rating == 4" >
                                <i v-for="index in 4" class="fas fa-star text-rating"></i><i v-for="index in 1" class="far fa-star text-rating"></i>
                            </div>
                            <div v-if="request.avg_rating > 3 && request.avg_rating < 4" >
                                <i v-for="index in 3" class="fas fa-star text-rating"></i><i v-for="index in 1" class="fas fa-star-half-alt text-rating"></i><i v-for="index in 1" class="far fa-star text-rating"></i>
                            </div>
                            <div v-if="request.avg_rating == 3" >
                                <i v-for="index in 3" class="fas fa-star text-rating"></i><i v-for="index in 2" class="far fa-star text-rating"></i>
                            </div>
                            <div v-if="request.avg_rating > 2 && request.avg_rating < 3" >
                                <i v-for="index in 2" class="fas fa-star text-rating"></i><i v-for="index in 1" class="fas fa-star-half-alt text-rating"></i><i v-for="index in 2" class="far fa-star text-rating"></i>
                            </div>
                            <div v-if="request.avg_rating == 2" >
                                <i v-for="index in 2" class="fas fa-star text-rating"></i><i v-for="index in 3" class="far fa-star text-rating"></i>
                            </div>
                            <div v-if="request.avg_rating > 1 && request.avg_rating < 2" >
                                <i v-for="index in 1" class="fas fa-star text-rating"></i><i v-for="index in 1" class="fas fa-star-half-alt text-rating"></i><i v-for="index in 3" class="far fa-star text-rating"></i>
                            </div>
                            <div v-if="request.avg_rating == 1" >
                                <i v-for="index in 1" class="fas fa-star text-rating"></i><i v-for="index in 4" class="far fa-star text-rating"></i>
                            </div>
                            <div v-if="!request.avg_rating" >
                                <span class="text-rating"><i>Not Rated</i></span>
                            </div>
                        </div>
                    </div>
                    <a :href="'/seller/requests/'+request.id">
                        <div class="view-offer-button mx-auto">Make Offers</div>
                    </a>
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

        }
    },
    methods:{
        checkOfferIsExist(request_id){
            for( var item in this.data.offer){
                if(this.data.offer[item].id == request_id){
                    return true;
                }
            }
            return false;
        }
    },
    mounted(){
        console.log(this.data);
    }
}

</script>

<style scoped>
    .content-warpper{
        width: 75%;
        margin: 0 auto;
    }

    .request-list{
        display: grid;
        grid-template-columns: 30% 30% 30%;
        grid-gap: 50px 5%;
    }
    .categoryimg{
        width: 50px;
    }
    .buyerimg{
        width: 50px;
        height: 50px;
        object-fit: cover;
    }

    .empty-img{
        opacity: 0.8;
    }

    .request-box{
        background-color: #fff;
        text-align: center;
        box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
        transition: all 0.2s ease-in-out 0s;
        position: relative;
        overflow: hidden;
    }
    .request-box:hover{
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    }

    .offeredflag{
        position: absolute;
        top: 20px;
        left: -35px;
        background-color: #902E2E;
        color: #FCFAF1;
        transform: rotate(-45deg);
    }
    .timestamp{
        position: absolute;
        top: 15px;
        right: 15px;
    }

    .request-box h4{
        font-weight: 600;
    }

    .view-offer-button {
        cursor: pointer;
        text-align: center;
        line-height: 45px;
        margin-top: 25px;
        max-width: 160px;
        width: 100%; 
        color: #FCFAF1;
        background-color: rgba(19, 65, 83, 1);

        box-shadow: inset 0 0 20px rgba(190, 218, 250, 0);
        outline-color: rgba(19, 65, 83, .5);
        outline-offset: 0px;
        text-shadow: none;
        transition: all 1250ms cubic-bezier(0.19, 1, 0.22, 1);
    }
    .view-offer-button:hover {
        box-shadow: inset 0 0 20px rgba(190, 218, 250, .5), 0 0 20px rgba(190, 218, 250, .2);
        outline: 1px solid;
        outline-color: rgba(190, 218, 250, 0);
        outline-offset: 15px;
        text-shadow: 1px 1px 2px #2E828B; 
    }

</style>