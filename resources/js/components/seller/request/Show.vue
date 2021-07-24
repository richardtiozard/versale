<template>
    <div class="componentwarpper">
        <div class="warpper min-vh-100">
            <div class="content-warpper bg-1 row custom-box-shadow">
                <div class="col-12 row px-5 pt-4 pb-3 m-0">
                    <div class="col-2">
                        <img :src="data.request[0].image" alt="" class="categoryimg">
                    </div>
                    <div class="col-10">
                        <h4 class="font-weight-600 d-inline">{{ data.request[0].title }}</h4>
                        <p v-if="data.request[0].status == 'Available'" class="text-3 d-inline float-right"><i class="fas fa-check"></i> {{data.request[0].status}}</p>
                        <p v-else class="text-8 d-inline float-right"><i class="fas fa-times"></i> {{data.request[0].status}}</p>
                        <p class="text-7 mt-2">{{ data.request[0].description }}</p>
                        
                        <p>
                            <span class="">Budget:</span><span class="text-3"> RM {{ data.request[0].budget }}</span>
                            <span class="ml-5">Quantity:</span><span class="text-3"> {{ data.request[0].quantity }}</span>
                        </p>
                        <img @mouseover="toggleProfile = true" @mouseleave="toggleProfile = false" :src="data.buyer[0].image" alt="" class="buyerimg">
                    </div>

                    <div v-if="toggleProfile" class="bg-1 px-5 py-4 m-0 text-left custom-box-shadow-2 buyerprofile">
                        <h4 class="font-weight-600 text-4">{{ data.buyer[0].username }}</h4>
                        <p class="text-1 mt-3 text-3"><i class="fas fa-map-marker-alt mr-2 text-8"></i> <i> {{ data.buyer[0].country }}, {{ data.buyer[0].city }}</i></p>
                        <div class="row justify-content-center">
                            <div class="col-auto"  v-if="data.buyer[0].avg_rating == 5" >
                                <i v-for="index in 5" class="fas fa-star text-rating"></i>
                            </div>
                            <div class="col-auto"  v-if="data.buyer[0].avg_rating > 4 && data.buyer[0].avg_rating < 5" >
                                <i v-for="index in 4" class="fas fa-star text-rating"></i><i v-for="index in 1" class="fas fa-star-half-alt text-rating"></i>
                            </div>
                            <div class="col-auto"  v-if="data.buyer[0].avg_rating == 4" >
                                <i v-for="index in 4" class="fas fa-star text-rating"></i><i v-for="index in 1" class="far fa-star text-rating"></i>
                            </div>
                            <div class="col-auto"  v-if="data.buyer[0].avg_rating > 3 && data.buyer[0].avg_rating < 4" >
                                <i v-for="index in 3" class="fas fa-star text-rating"></i><i v-for="index in 1" class="fas fa-star-half-alt text-rating"></i><i v-for="index in 1" class="far fa-star text-rating"></i>
                            </div>
                            <div class="col-auto"  v-if="data.buyer[0].avg_rating == 3" >
                                <i v-for="index in 3" class="fas fa-star text-rating"></i><i v-for="index in 2" class="far fa-star text-rating"></i>
                            </div>
                            <div class="col-auto"  v-if="data.buyer[0].avg_rating > 2 && data.buyer[0].avg_rating < 3" >
                                <i v-for="index in 2" class="fas fa-star text-rating"></i><i v-for="index in 1" class="fas fa-star-half-alt text-rating"></i><i v-for="index in 2" class="far fa-star text-rating"></i>
                            </div>
                            <div class="col-auto"  v-if="data.buyer[0].avg_rating == 2" >
                                <i v-for="index in 2" class="fas fa-star text-rating"></i><i v-for="index in 3" class="far fa-star text-rating"></i>
                            </div>
                            <div class="col-auto"  v-if="data.buyer[0].avg_rating > 1 && data.buyer[0].avg_rating < 2" >
                                <i v-for="index in 1" class="fas fa-star text-rating"></i><i v-for="index in 1" class="fas fa-star-half-alt text-rating"></i><i v-for="index in 3" class="far fa-star text-rating"></i>
                            </div>
                            <div class="col-auto"  v-if="data.buyer[0].avg_rating == 1" >
                                <i v-for="index in 1" class="fas fa-star text-rating"></i><i v-for="index in 4" class="far fa-star text-rating"></i>
                            </div>
                            <div v-if="!data.buyer[0].avg_rating" >
                                <span class="text-rating"><i>Not Rated</i></span>
                            </div>
                            <div class="col-auto"><p class="text-7">({{data.buyer[0].num_rating}} Reviews)</p></div>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="content-warpper row mt-5 justify-content-between">
                <div class="col-7 bg-1 custom-box-shadow p-4">
                    <h4 class="lead">My Offers</h4>
                    <hr>
                    <div v-if="isSuccess" class="successmsg p-3 mt-4"><i class="fas fa-check text-9 mr-2"></i> Your product has been successfully offered.</div>
                    <div v-if="isError" class="errormsg p-3 mt-4"><i class="fas fa-times text-8 mr-2"></i> {{ errortext }}</div>
                    <div v-if="isEmpty" class="errormsg p-3 mt-4"><i class="fas fa-exclamation text-8 mr-2"></i> The request is no longer accepting any offers.</div>
                    <div id="myoffers" class="mt-3">
                        <div v-if="data.offers==''" class="text-7 w-100 text-center">
                            <img :src="'../../img/illustrator/emptyview.png'" class="pointer-events-none empty-img" alt="">
                            <p>No offers found, you may want to select your products.</p>
                        </div>
                        <div v-for="(offer, index) in data.offers" id="product-box" class="row p-3">
                            <div class="col-1 font-weight-600">
                                {{index + 1}}.
                            </div>
                            <div class="col-4">
                                <img :src="offer.image" alt="" class="offerimg">
                            </div>
                            <div class="col-5">
                                <h5 class="d-block font-weight-600">{{offer.name}}</h5>
                                <p>
                                    <span class="d-block text-7 mt-1">{{offer.description}}</span>
                                    <span class="d-block text-7 mt-3">Brand: {{offer.brand}}</span>
                                    <span class="d-block text-7">Price: RM {{offer.price}}</span>
                                    <span class="d-block text-7 mt-3">Status: <i class="text-3">{{offer.status}}</i></span>
                                </p>
                            </div>
                            <div class="col-2 d-flex align-items-center justify-content-center">
                                <i @click="openConfirmDeleteModal(offer)" class="fas fa-trash-alt text-8 cursor-pointer p-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4 bg-1 custom-box-shadow p-4">
                    <h4 class="lead">My Products</h4>
                    <hr>
                    <div id="myproducts" class="">
                        <div v-for="(product, index) in data.products" @click="createOffer(product)" id="product-box" class="row p-3 cursor-pointer">
                            <div class="col-2 font-weight-600">
                                {{index + 1}}.
                            </div>
                            <div class="col-6">
                                <h6 class="d-block font-weight-600">{{product.name}}</h6>
                                <p>
                                    <span class="d-block text-7 mt-1">Brand: {{product.brand}}</span>
                                    <span class="d-block text-7">Price: RM {{product.price}}</span>
                                    <span class="d-block text-7">Stock: {{product.stock}}</span>
                                </p>
                            </div>
                            <div class="col-4 d-flex align-items-center justify-content-center">
                                <i class="fas fa-plus"></i>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

        </div>

        <Footers/>
        <confirm-modal v-if="toggleConfirmModal" @confirmed="deleteOffer" @closeConfirmModal="closeConfirmModal" :title="confirmModalTitle"></confirm-modal>
    </div>
    
</template>

<script>
import Footers from '../../template/Footers.vue'
import ConfirmModal from '../../template/ConfirmModal.vue';

export default {
    props: ['data'],
    components:{
        Footers,
        ConfirmModal,
    },
    data(){
        return{
            isSuccess: false,
            isError: false,
            errortext: "",
            isEmpty: false,

            toggleProfile:false,

            toggleConfirmModal: false,
            confirmModalTitle: '',
            selected_offer_id: '',
        }
    },
    methods:{

        /* CREATE OFFERS */
        createOffer(product){

            if (this.data.request[0].status == 'Not Available'){
                this.isEmpty = true;
                this.isSuccess = false;
                this.isError = false;
            }
            else{

                var isDuplicate = false;
                for (var item in this.data.offers){
                    if (this.data.offers[item].product_id == product.id){
                        isDuplicate = true;
                        break;
                    }
                }
                if(isDuplicate){
                    this.isEmpty = false;
                    this.isSuccess = false;
                    this.isError = true;
                    this.errortext = 'You have already offered the same product.'
                }
                else{
                    axios.post('/seller/offers', {
                        request_id: this.data.request[0].id,
                        product_id: product.id
                    })
                    .then(response => {
                        this.isEmpty = false;
                        this.isSuccess = true;
                        this.isError = false;
                        window.location.href = "/seller/requests/"+ this.data.request[0].id;
                    })
                }
            }
        },


        /* DELETE OFFERS */
        openConfirmDeleteModal(offer){
            if (offer.status == 'Accepted'){
                this.isEmpty = false;
                this.isSuccess = false;
                this.isError = true;
                this.errortext = 'Your offer has been accepted, unable to delete.'
            }
            else{
                this.selected_offer_id = offer.offer_id;
                this.confirmModalTitle = "Are you sure you want to delete your offer '" + offer.name + "' ?";
                this.toggleConfirmModal = true;
                document.body.style.overflow = 'hidden';
            }
        },
        closeConfirmModal(){
            this.toggleConfirmModal = false;
            document.body.style.overflow = 'auto';
        },
        deleteOffer(){
            console.log(this.selected_offer_id );
            axios.delete('/seller/offers',{ 
                data: { 
                    offer_id: this.selected_offer_id 
                } 
            })
            .then( response => {
                console.log(response.data);
                this.closeConfirmModal();
                window.location.href = "/seller/requests/"+ this.data.request[0].id;
            })
            .catch ( error => {
                console.log(error.response.data);
            })
        },
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
    .categoryimg{
        width: 80px;
    }
    .buyerimg{
        width: 50px;
        height: 50px;
        object-fit: cover;
        background-color: #fff;
        border-radius: 50%;
        position: absolute;
        right: 20px;
        bottom: 20px;
    }
    .buyerprofile{
        position: absolute;
        right: 200px;
        top: 0px;
        height: 150px;
        z-index: 1;
    }
    .buyerprofile::before {
        content: "";
        position: absolute;
        background-color: #fff;
        width: 30px;
        height: 30px;
        top: 75px;
        right: -15px;
        transform: rotate(45deg);
    }
    .offerimg{
        height: 150px;
        width: 100%;
        object-fit:contain;
    }
    .empty-img{
        opacity: 0.8;
    }

    #myoffers, #myproducts{
        height: 600px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    #product-box:hover{
        background-color: #f7f7f7;
    }

</style>